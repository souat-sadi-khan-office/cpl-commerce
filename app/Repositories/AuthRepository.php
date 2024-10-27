<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\UserWallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interface\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function login( $request, $guard)
    {
        $credentials = $request->only('email','password');
        
        if (Auth::guard($guard)->attempt($credentials)) {
            if(Auth::guard('customer')->check()) {
                $cartItems = Cart::where('ip', $request->ip())->get();
                if($cartItems) {
                    foreach ($cartItems as $item) {
                        $item->user_id = Auth::guard('customer')->user()->id;
                        $item->save();
                    }
                }
            }

            return $guard;
        }

        return 0;
    }

    public function registerUser($request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'customer_first_name' => 'required|string|max:255',
            'customer_last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'customer_phone' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()];
        }

        // User Creation
        DB::beginTransaction();

        $customer = User::create([
            'currency_id' => 1,
            'name' => $request->customer_first_name .' '. $request->customer_last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'user.png',
            'status' => 1
        ]);

        if($customer) {

            if($request->customer_phone) {
                UserPHone::create([
                    'user_id' => $customer->id,
                    'phone_number' => $request->customer_phone,
                    'is_default' => 1,
                    'is_verified' => 0
                ]);
            }

            UserWallet::create([
                'user_id' => $customer->id,
                'amount' => 0,
                'status' => 'active',
            ]);

            DB::commit();
        } else {
            DB::rollBack();
        }

        return $customer;
    }

    public function social_login($socialUser, $provider) 
    {
        $user = User::where('email', $socialUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'currency_id' => 1,
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider_id' => $socialUser->getId(),
                'provider_name' => $provider,
                'avatar' => $socialUser->getAvatar(),
                'password' => Hash::make(123456)
            ]);

            UserWallet::create([
                'user_id' => $user->id,
                'amount' => 0,
                'status' => 'active',
            ]);
        }

        return $user;
    }
    
    public function customer_login( $request, $guard)
    {
        $cred = $request->only('email','password');

        if (Auth::guard($guard)->attempt($cred)) {
            return $guard;
        }

        return 0;
    }
    
    public function form()
    {
        return view('backend.auth.login');
    }
    
    public function customer_login_form()
    {
        return view('frontend.auth.login');
    }
    
    public function customer_forgot_password_form()
    {
        return view('frontend.auth.forget-password');
    }

    public function customer_register_form()
    {
        return view('frontend.auth.register');
    }

    public function logout($guard)
    {
        Auth::guard($guard)->logout();
    }

    public function customer_logout($guard)
    {
        Auth::guard($guard)->logout();
    }
}