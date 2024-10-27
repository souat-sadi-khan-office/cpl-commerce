<?php

namespace App\Repositories;

use DataTables;
use App\Models\City;
use App\Models\Order;
use App\Models\Country;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interface\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function index($request)
    {
        return Order::when(isset($request->status) && $request->status == 'pending', function ($q) {
            $q->where('status', 'pending');
        })
            ->when(isset($request->status) && $request->status == 'packaging', function ($q) {
                $q->where('status', 'packaging');
            })
            ->when(isset($request->status) && $request->status == 'shipping', function ($q) {
                $q->where('status', 'shipping');
            })
            ->when(isset($request->status) && $request->status == 'out_of_delivery', function ($q) {
                $q->where('status', 'out_of_delivery');
            })
            ->when(isset($request->status) && $request->status == 'delivered', function ($q) {
                $q->where('status', 'delivered')->where('is_delivered', 1);
            })
            ->when(isset($request->status) && $request->status == 'returned', function ($q) {
                $q->where('status', 'returned');
            })
            ->when(isset($request->status) && $request->status == 'failed', function ($q) {
                $q->where('status', 'failed');
            })
            ->when(isset($request->payment_status) && $request->payment_status == 'Paid', function ($q) {
                $q->where('payment_status', 'Paid');
            })
            ->when(isset($request->payment_status) && $request->payment_status == 'Paid', function ($q) {
                $q->where('payment_status', 'Paid');
            })
            ->when(isset($request->refund_requested) && $request->is_refund_requested, function ($q) {
                $q->where('is_refund_requested', 1);
            })->with('details:id,order_id,phone,email', 'user:id,name', 'payment:id,currency,gateway_name', 'currency:id,code,symbol')->get()->map(function ($order) {
                return [
                    'id' => $order->id,
                    'unique_id' => $order->unique_id,
                    'user_name' => $order->user->name,
                    'phone' => $order->details->phone,
                    'email' => $order->details->email,
                    'currency' => $order->payment->currency ?? $order->currency->code,
                    'currency_symbol' => $order->currency->symbol ?? null,
                    'gateway_name' => $order->is_cod ? 'Cash on Delivery' : $order->payment->gateway_name ?? null,
                    'payment_status' => $order->payment_status,
                    'status' => $order->is_refund_requested ? "Refund Requested" : $order->status,
                    'amount' => $order->final_amount,
                    'created_at' => $order->created_at
                ];
            });
    }

    public function indexDatatable($models)
    {
        return Datatables::of($models)
            ->addIndexColumn()

            ->editColumn('status', function ($model) {
                if ($model['status'] == 'pending') {
                    $badge = 'warning text-dark';
                } elseif ($model['status'] == 'delivered') {
                    $badge = 'success';
                } elseif ($model['status'] == 'packaging') {
                    $badge = 'info text-dark';
                } elseif ($model['status'] == 'shipping' || $model['status'] == 'out_of_delivery') {
                    $badge = 'info text-dark';
                } else {
                    $badge = 'danger';
                }
                return '<div class="text-center"><span class="badge bg-' . $badge . '">' . ucfirst($model['status']) . '</div>';
            })->editColumn('payment_status', function ($model) {
                $paymentBadge = $model['payment_status'] == 'Paid' ? 'success' : 'danger';
                return '<div class="text-center"><span class="badge bg-' . $paymentBadge . ' text-white">' . str_replace('_', ' ', ucfirst($model['payment_status'])) . '</div>';
            })
            ->editColumn('gateway_name', function ($model) {
                $gatewayBadge = $model['gateway_name'] == 'Cash on Delivery' ? 'dark' : 'success';
                return '<div class="text-center"><span class="badge bg-' . $gatewayBadge . ' text-white">' . ucfirst($model['gateway_name']) . '</div>';
            })->editColumn('unique_id', function ($model) {

                return '<a class="dropdown-item" href="' . route('admin.order.invoice', $model['id']) . '">
                <i class="bi bi-receipt"></i>
               ' . strtoupper(str_replace('#', '', $model['unique_id'])) . '
                </a>';
            })

            ->editColumn('amount', function ($model) {

                return $model['currency_symbol'] . round($model['amount'], 2);
            })
            ->editColumn('created_at', function ($model) {

                return $model['created_at']->format('d M Y, h:i:s A');;
            })
            ->addColumn('customer', function ($model) {
                return ' <div class="row">
                            <div class="col-md-12">' . $model['user_name'] . '</div>
                            <div class="col-md-12">' . $model['email'] . '</div>
                        </div>';
            })
            ->addColumn('action', function ($model) {
                return view('backend.order.action', compact('model'));
            })
            ->rawColumns(['action', 'unique_id', 'status', 'customer', 'payment_status', 'gateway_name', 'amount', 'created_at'])
            ->make(true);
    }

    public function store($request)
    {
        // Step 1: Validate and Modify Data 
        $this->validateRequest($request);
        $getProductsData = $this->productsdata($request['product'], $request['country_id'], $request['shipping_city'] ?? $request['billing_city']);

        $productIds = $getProductsData->pluck('id')->toArray();
        $details['products'] = $getProductsData->map(function ($item) {
            return [
                'id' => $item['id'],
                'stock_id' => $item['stock']->id,
                'name' => $item['name'],
                'qty' => $item['order_qty'],
                'slug' => $item['slug'],
                'total_price' => $item['unit_price'] * $item['order_qty'],
                'unit_price' => $item['unit_price'],
                'discount' => $item['discount'],
                'discount_type' => $item['discount_type'],
            ];
        })->toArray();

        $details['company_name'] = $request['customer_company'];
        $details['user_name'] = $request['customer_name'];

        $billingAddress = $this->generateAddress($request, 'billing');
        $shippingAddress = isset($request['different_shipping_address'])
            ? $this->generateAddress($request, 'shipping')
            : $billingAddress;

        try {
            DB::beginTransaction();

            // Step 2: Create the order
            $order = Order::create([
                'unique_id' => uniqid('#'),
                'payment_id' => null,
                'user_id' => Auth::guard('customer')->user()->id,
                'order_amount' => round($request['subtotal'] + $request['discount'], 2),
                'tax_amount' => round($request['total_tax'], 2),
                'discount_amount' => round($request['discount'], 2),
                'final_amount' => round($request['subtotal'], 2),
                'currency_id' => Session::get('currency_id') ?? Auth::guard('customer')->user()->currency_id,
                'payment_status' => 'Not_Paid',
                'status' => 'pending',
                'is_delivered' => false,
                'is_cod' => $request['payment_option'] === 'cash_on_delivery',
                'is_refund_requested' => false,
            ]);

            // Step 4: Create the order details
            OrderDetail::create([
                'order_id' => $order->id,
                'product_ids' => json_encode($productIds),
                'details' => json_encode($details),
                'notes' => $request['notes'] ?? null,
                'shipping_method' => $request['shipping_method'] ?? 'Default',
                'shipping_address' => $shippingAddress,
                'billing_address' => $billingAddress,
                'phone' => $request['customer_phone'],
                'email' => $request['customer_email'],
            ]);

            // // Step 5: Adjust Stock for Paid Orders
            // if(!$order->is_cod){
            //     $this->adjustStock($getProductsData);
            // }


            DB::commit();
            // Return success response
            return [
                'status' => true,
                'order' => $order,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


    public function details($id)
    {
        $order = Order::where('id', $id)
            ->with('details', 'payment:id,currency,gateway_name', 'currency:id,code,symbol', 'user:id,name')
            ->first();

        if ($order) {
            return [
                'id' => $order->id,
                'unique_id' => $order->unique_id,
                'user_name' => ucfirst($order->user->name),
                'phone' => $order->details->phone,
                'email' => $order->details->email,
                'product_ids' => json_decode($order->details->product_ids),
                'user_company' => json_decode($order->details->details)->company_name,
                'details' => json_decode($order->details->details)->products,
                'stock_ids_and_qtys' => array_map(function ($product) {
                    return [
                        'stock_id' => $product->stock_id,
                        'qty' => $product->qty,
                    ];
                }, json_decode($order->details->details)->products),
                'currency' => $order->payment->currency ?? $order->currency->code,
                'gateway_name' => $order->is_cod ? 'Cash on Delivery' : $order->payment->gateway_name ?? null,
                'is_delivered' => $order->is_delivered,
                'is_cod' => $order->is_cod,
                'payment_status' => str_replace('_', ' ', $order->payment_status),
                'status' => $order->status,
                'is_refund_requested' => $order->is_refund_requested,
                'order_amount' => ($order->currency->symbol ?? '') . $order->order_amount,
                'discount_amount' => ($order->currency->symbol ?? '') . $order->discount_amount,
                'tax_amount' => ($order->currency->symbol ?? '') . $order->tax_amount,
                'final_amount' => ($order->currency->symbol ?? '') . $order->final_amount,
                'note' => $order->details->notes,
                'shipping_method' => $order->details->shipping_method,
                'shipping_address' => $order->details->shipping_address,
                'billing_address' => $order->details->billing_address,
                'created_at' => $order->created_at->format('d M Y, h:i:s A')
            ];
        }

        return null;
    }
    public function updateStatus($request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found.'
            ]);
        }

        $type = $request->input('type');
        $newStatus = $request->input('value');
        $currentStatus = $order->status;

        // Define restricted transitions
        $restrictedTransitions = [
            'packaging' => ['pending'],
            'shipping' => ['pending', 'packaging'],
            'out_of_delivery' => ['pending', 'packaging', 'shipping'],
            'delivered' => ['pending', 'packaging', 'shipping', 'out_of_delivery'],
            'returned' => ['pending', 'packaging', 'shipping', 'out_of_delivery', 'delivered'],
        ];

        // Check if transition is allowed
        if ($type === 'order_status' && isset($restrictedTransitions[$currentStatus]) && in_array($newStatus, $restrictedTransitions[$currentStatus])) {
            return response()->json([
                'status' => false,
                'message' => "Cannot change status from $currentStatus to $newStatus."
            ]);
        }
        // Check if payment_status changes from Unpaid to Paid
        if ($type === 'payment_status' && $order->payment_status === 'Not_Paid' && $newStatus === 'Paid' && $order->is_cod) {
            // Get stock_ids and quantities from the order
            $stockIdsAndQtys = $request->input('stock_ids_and_qtys');

            // Update stock quantities
            $stock=$this->updateStockQuantities($stockIdsAndQtys);
            if(!$stock['status']){
                return response()->json($stock);
            }
        }

        if(!$order->is_cod && $type=='payment_status'&& $order->payment_status === 'Paid' && $newStatus === 'Not_Paid' ){

            return response()->json([
                'status' => false,
                'message' => "Cannot change Paid Payments to Unpaid."
            ]);
        }

        // No restrictions for 'failed'
        if ($type === 'order_status' && $newStatus === 'failed') {
            $order->status = $newStatus;
        } elseif ($type === 'order_status') {
            if ($newStatus === 'delivered') {
                $order->is_delivered = !$order->is_delivered;
            }
            $order->status = $newStatus;
        } elseif ($type === 'payment_status') {
            $order->payment_status = $newStatus;
        }

        $order->save();

        return response()->json([
            'status' => true,
            'message' => ucfirst(str_replace('_', ' ', $type)) . ' updated successfully.'
        ]);
    }

    private function updateStockQuantities(array $stockIdsAndQtys)
    {
        $stockIds = array_column($stockIdsAndQtys, 'stock_id');
        $quantities = array_column($stockIdsAndQtys, 'qty', 'stock_id');
    
        $stocks = ProductStock::whereIn('id', $stockIds)->with('product:id,name')->get();
    
        $insufficientStocks = $stocks->filter(function ($stock) use ($quantities) {
            return isset($quantities[$stock->id]) && $stock->stock < $quantities[$stock->id];
        })->map(function ($stock) use ($quantities) {
            return [
                'stock_id' => $stock->id,
                'product' => $stock->product->name,
                'available' => $stock->stock,
                'requested' => $quantities[$stock->id],
            ];
        });
    
        if ($insufficientStocks->isNotEmpty()) {
            return [
                'status' => false,
                'message' => 'Insufficient stock available for "'.$insufficientStocks[0]['product']. '" Requested: '.$insufficientStocks[0]['requested'].', Available: '.$insufficientStocks[0]['available'],
            ];
        }
    
        $stocks->map(function ($stock) use ($quantities) {
            $newStockQuantity = $stock->stock - $quantities[$stock->id];
    
            $stock->stock = max(0, $newStockQuantity); 
            $stock->in_stock = $stock->stock > 0; 
    
            $stock->save();
        });
    
        return [
            'status' => true,
            'message' => 'Stock quantities updated successfully.',
        ];
    }
    




    private function adjustStock($productsData)
    {
        foreach ($productsData as $product) {
            $stockItem = $product['stock'];
            if ($stockItem) {
                $this->updateStock($stockItem, $product['order_qty']);
            }
        }
    }

    private function updateStock($stockItem, $quantity)
    {
        $newStock = $stockItem->stock - $quantity;

        $stockItem->update(['stock' => $newStock]);
    }


    private function validateRequest($request)
    {
        try {
            $request->validate([
                'customer_name' => 'required',
                'customer_email' => 'required|email',
                'customer_phone' => 'required',
                'customer_company' => 'required',
                'billing_city' => 'required|exists:cities,id',
                'billing_area' => 'required',
                'billing_address' => 'required',
                'billing_address2' => 'required',
                'product' => 'required|array',
                'shipping_charge' => 'required|numeric',
                'total_tax' => 'required|numeric',
                'discount' => 'required|numeric',
                'subtotal' => 'required|numeric',
                'payment_option' => 'required',
                'currency_code' => 'required|exists:currencies,code',
            ]);

            if ($request->filled('different_shipping_address')) {
                $request->validate([
                    'shipping_city' => 'required',
                    'shipping_area' => 'required',
                    'shipping_address' => 'required',
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('order.checkout')
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    private function productsdata($products, $countryId, $cityId)
    {
        return collect($products)->map(function ($product) use ($countryId, $cityId) {
            $item = Product::where('slug', $product['slug'])
                ->select('id', 'slug', 'name', 'unit_price', 'discount', 'discount_type', 'sku', 'stock_types')
                ->with(['stock' => function ($query) {
                    $query->select('id', 'stock', 'number_of_sale', 'in_stock', 'product_id')
                        ->where('in_stock', '>', 0);
                }])
                ->first();
            if ($item) {
                if ($item->stock_types === 'globally') {
                    $stockItem = $item->stock->first();
                } else {
                    $stockItem = $item->stock->filter(function ($stock) use ($countryId, $cityId) {
                        if ($countryId && $stock->country_id == $countryId) {
                            return true;
                        }
                        if ($cityId && $stock->city_id == $cityId) {
                            return true;
                        }
                        if (!$cityId) {
                            $country = Country::find($countryId);
                            if ($country && $stock->zone_id == $country->zone_id) {
                                return true;
                            }
                        }
                        return false;
                    })->first();
                }

                if ($stockItem) {
                    return [
                        'id' => $item->id,
                        'slug' => $item->slug,
                        'name' => $item->name,
                        'unit_price' => $item->unit_price,
                        'discount' => $item->discount,
                        'discount_type' => $item->discount_type,
                        'sku' => $item->sku,
                        'stock' => $stockItem,
                        'order_qty' => $product['qty'],
                    ];
                }
            }

            return null;
        })->filter();
    }


    private function generateAddress($request, string $type)
    {
        $address = $request["{$type}_address"];

        if (isset($request["{$type}_address2"])) {
            $address .= ', ' . $request["{$type}_address2"];
        }

        $address .= ', ' . $request["{$type}_area"];

        $cityName = City::find($request["{$type}_city"])->name ?? '';
        if ($cityName) {
            $address .= ', ' . $cityName;
        }

        $countryName = $request['country_name'] ?? '';
        if ($countryName) {
            $address .= ', ' . $countryName;
        }

        return $address;
    }
}
