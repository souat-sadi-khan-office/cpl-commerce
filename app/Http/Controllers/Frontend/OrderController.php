<?php

namespace App\Http\Controllers\Frontend;

use App\CPU\paypal;
use App\Models\City;
use App\Models\Order;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\Interface\OrderRepositoryInterface;

class OrderController extends Controller
{
    private $orderRepository;
    private $userRepository;
    private $product;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository,
        ProductRepositoryInterface $product,
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->product = $product;
    }

    public function checkout(Request $request)
    {

        $countryName = Session::get('user_country');
        $country = Country::where('name', $countryName)->with(['city' => function ($query) {
            $query->where('status', 1)->select('id', 'name', 'country_id');
        }])->first();
        $countryID = $country->id;
        $cities = $country->city;
        $currencyCode = Session::get('currency_code');
        $userInfo = $this->userRepository->informations($countryID);
        // dd($userInfo);

        // cart
        $items = [];
        $counter = 0;
        $total_price = 0;
        $tax_amount = 0;
        $models = [];
        if (Auth::guard('customer')->check()) {
            $cart = Cart::where('user_id', Auth::guard('customer')->user()->id)->first();
        } else {
            $cart = Cart::where('ip', $request->ip())->first();
        }

        if (!$cart) {
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::guard('customer')->user()->id ?? null, 'ip' => $request->ip()],
                ['total_quantity' => 0, 'currency_id' => 1]
            );
        }

        $items = CartDetail::where('cart_id', $cart->id)->get();

        $cart_updated = false;
        foreach ($items as $item) {
            $stockResponse = getProductStock($item->product_id);
            if (!$stockResponse['status']) {
                $cart_updated = true;
                $itemQuantity = $item->quantity;
                $item->delete();
                $cart->total_quantity -= $itemQuantity;
                $cart->save();
            } else {
                $product_tax_amount = 0;
                $price = $this->product->discountPrice($item->product);
                $total_price += ($price * $item->quantity);

                if ($item->product->taxes->isNotEmpty()) {
                    foreach ($item->product->taxes as $tax) {
                        if ($tax->tax_type == 'percent') {
                            $product_tax_amount = (($item->product->unit_price * $tax->tax) / 100) * $tax->quantity;
                        } else {
                            $product_tax_amount = ($tax->tax * $item->quantity);
                        }
                    }

                    $tax_amount += $product_tax_amount;
                }

                $models[] = [
                    'id' => $item->id,
                    'slug' => $item->product->slug,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'tax' => $product_tax_amount
                ];
            }
        }

        $total_price += $tax_amount;
        $shipping_charge = get_settings('system_default_delivery_charge') ?? 10;
        $total_price += $shipping_charge;
        if (count($models) == 0) {
            return redirect()->route('home')->withErrors('Your Cart is Empty!');
        }
        return view('frontend.order.checkout', compact('userInfo', 'shipping_charge', 'tax_amount', 'total_price', 'countryName', 'countryID', 'models', 'cities', 'currencyCode'));
    }

    public function store(Request $request)
    {
        if (!isset($request->token) && !isset($request->PayerID)) {

            $order = $this->orderRepository->store($request);
            if ($order['order']->is_cod) {
                return redirect()->route('home');
            }
        }
        if ($request->payment_option == 'paypal' && $order['order']->id) {
            $payment = paypal::processPayment($request->currency_code, $request->subtotal, $order['order']->unique_id);
        }
       
        if(json_decode($payment->getContent())){
            return redirect()->back()->withErrors(json_decode(json_decode($payment->getContent())->error));
         }
        elseif (is_array($payment) && isset($payment['approval_url'])) {
            return redirect($payment['approval_url']);
        }

        if (isset($request->token) && isset($request->PayerID)) {
            $capture = paypal::capturePayment($request->token);
            $capture_contents = json_decode($capture->getContent());

            if (isset($capture_contents->details->status) && $capture_contents->details->status === 'COMPLETED') {
                // Update payment information
                $pay = Payment::where('payment_order_id', $capture_contents->details->id)->first();

                if ($pay) {
                    $pay->update([
                        'email' => $capture_contents->details->payer->email_address,
                        'payer_id' => $capture_contents->details->payer->payer_id,
                        'status' => $capture_contents->details->status,
                    ]);

                    // Update order status
                    $order = Order::with('details')->where('unique_id', $pay->payment_unique_id)->first();
                    $order->update([
                        'payment_id' => $pay->id,
                        'payment_status' => 'Paid',
                    ]);
                    $details = json_decode($order->details->details);
                    $this->adjustStock($details->products);

                    return redirect()->route('home')->with(['success'=>"Order Completed!"]);
                }
            } else {
                return redirect()->back()->with(['error' => json_decode($capture_contents->error)->details[0]->issue]);
            }
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong!']);
    }

    public function address($id)
    {
        $address = UserAddress::find($id);
        if (!isset($address)) {
            return response()->json(['success' => false, 'massage' => 'Address Not Found']);
        }
        return response()->json(['success' => true, 'address' => $address]);
    }


    private function adjustStock($products)
    {
        foreach ($products as $product) {
            $stockId = $product->stock_id;
            $qty = (int) $product->qty;
            $stock = ProductStock::find($stockId);
            if ($stock) {
                if ($stock->stock >= $qty) {
                    $stock->stock -= $qty;
                    $stock->save();
                } else {
                    dd(132);
                }
            }
        }
    }
}
