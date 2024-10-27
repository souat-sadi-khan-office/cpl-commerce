<?php

namespace App\Repositories;

use DataTables;
use App\CPU\Images;
use App\Models\Coupon;
use App\Models\userCoupon;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interface\CouponRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class CouponRepository implements CouponRepositoryInterface
{
    public function all()
    {
        return Coupon::all();
    }

    public function dataTable()
    {
        $models = $this->all();
        return Datatables::of($models)
            ->addIndexColumn()
            ->editColumn('status', function ($model) {
                $checked = $model->status == 1 ? 'checked' : '';
                return '<div class="form-check form-switch"><input data-url="' . route('admin.coupon.status', $model->id) . '" class="form-check-input" type="checkbox" role="switch" name="status" id="status' . $model->id . '" ' . $checked . ' data-id="' . $model->id . '"></div>';
            })
            ->addColumn('action', function ($model) {
                return view('backend.coupon.action', compact('model'));
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function find($id)
    {
        return Coupon::findOrFail($id);
    }

    public function create($data)
    {
        Coupon::create([
            'coupon_code' => $data->coupon_code,
            'minimum_shipping_amount' => $data->minimum_shipping_amount,
            'discount_amount' => $data->discount_amount,
            'discount_type' => $data->discount_type,
            'maximum_discount_amount' => $data->maximum_discount_amount,
            'start_date' => $data->start_date ? date('Y-m-d', strtotime($data->start_date)) : null,
            'end_date' => $data->end_date ? date('Y-m-d', strtotime($data->end_date)) : null,
            'status' => $data->status
        ]);

        $json = ['status' => true, 'load' => true, 'message' => 'Coupon created successfully'];
        return response()->json($json);
    }

    public function update($id, $data)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->coupon_code = $data->coupon_code;
        $coupon->minimum_shipping_amount = $data->minimum_shipping_amount;
        $coupon->discount_amount = $data->discount_amount;
        $coupon->discount_type = $data->discount_type;
        $coupon->maximum_discount_amount = $data->maximum_discount_amount;
        $coupon->start_date = $data->start_date ? date('Y-m-d', strtotime($data->start_date)) : null;
        $coupon->end_date = $data->end_date ? date('Y-m-d', strtotime($data->end_date)) : null;
        $coupon->status = $data->status;
        $coupon->update();

        return response()->json(['status' => true, 'load' => true, 'message' => 'Coupon updated successfully.']);
    }

    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        return $coupon->delete();
    }

    public function updateStatus($request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon not found.'], 404);
        }

        $coupon->status = $request->input('status');
        $coupon->save();
        return response()->json(['success' => true, 'message' => 'Coupon status updated successfully.']);
    }

    public function findByCoupon($couponCode)
    {
        return Coupon::where('status', 1)->where('coupon_code', $couponCode)->first();
    }

    public function userCoupon($couponId)
    {
        return userCoupon::where('user_id', Auth::guard('customer')->user()->id)->where('coupon_id', $couponId)->first();
    }

    public function checkCoupon($data)
    {
        $validator = Validator::make($data, [
            'coupon_code' => 'required|string|min:5|max:15|exists:coupons,coupon_code',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'validator' => true, 'message' => $validator->errors()]);
        }

        // check the coupon
        $coupon = $this->findByCoupon($data['coupon_code']);
        if(!$coupon) {
            return response()->json(['status' => false, 'message' => 'Coupon not found']);
        }

        // check the user is already used this
        $userCoupon = $this->userCoupon($coupon->id);
        if($userCoupon) {
            return response()->json(['status' => false, 'message' => 'This coupon is already used.']);
        }

        // check start_date & end_date
        if($coupon->start_date && ($coupon->start_date > date('Y-m-d'))) {
            return response()->json(['status' => false, 'message' => 'You can use this coupon after '. get_system_date($coupon->start_date)]);
        }

        // check minimum shipping amount
        if($coupon->end_date && ($coupon->end_date < date('Y-m-d'))) {
            return response()->json(['status' => false, 'message' => 'This coupon is expired on '. get_system_date($coupon->end_date)]);
        }

        // set up discount amount
        $total_price = 0;
        $discounted_amount = 0;
        $discounted_price = 0;
        $tax_amount = 0;

        $cart = Cart::where('user_id', Auth::guard('customer')->user()->id)->first();
        $items = CartDetail::where('cart_id', $cart->id)->get();

        foreach ($items as $item) {
            $stockResponse = getProductStock($item->product_id);
            if (!$stockResponse['status']) {
                $cart_updated = true;
                $itemQuantity = $item->quantity;
                $item->delete();
                $cart->total_quantity -= $itemQuantity;
                $cart->save();
            } else {
                $productRepository = app(Interface\ProductRepositoryInterface::class);;

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

                $price = $productRepository->discountPrice($item->product);
                $total_price += ($price * $item->quantity);
            }
        }

        $total_price = convert_price($total_price);

        if($coupon->minimum_shipping_amount > $total_price) {
            return response()->json(['status' => false, 'message' => 'Minimum '. format_price(convert_price($coupon->minimum_shipping_amount)) .' is required to apply this coupon']);
        }

        // check maximum_discount_amount
        if ($coupon->discount_type == 'percent') {
            $discounted_amount = ($total_price * $coupon->discount_amount) / 100;
        } elseif ($coupon->discount_type == 'amount') {
            $discounted_amount = $coupon->discount_amount;
        }

        if($coupon->maximum_discount_amount < $discounted_amount) {
            $discounted_amount = $coupon->maximum_discount_amount;
        }

        $shipping_charge = get_settings('system_default_delivery_charge')??10;
        $discounted_price = $total_price - $discounted_amount;
        $total_amount = ($total_price + $tax_amount + $shipping_charge) - $discounted_amount;

        // return true
        return response()->json(['status' => true, 'message' => 'Coupon Added Successfully.', 'formatted_amount' => format_price(convert_price($discounted_amount)), 'total_amount' => format_price(convert_price($total_amount)), 'amount' => $discounted_price ]);
    }
}
