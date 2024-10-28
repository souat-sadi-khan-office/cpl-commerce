<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\CPU\Helpers;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\Interface\AuthRepositoryInterface;
use App\Repositories\Interface\ProductRepositoryInterface;

class LoginController extends Controller
{

    protected $authRepository;
    protected $productRepository;

    public function __construct(
        AuthRepositoryInterface $authRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->authRepository = $authRepository;
        $this->productRepository = $productRepository;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $this->loginOrRegisterUser($user, 'google');
    }

    // Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        $this->loginOrRegisterUser($user, 'facebook');
    }

    // Common function to handle both Google and Facebook logins
    protected function loginOrRegisterUser($socialUser, $provider)
    {
        $user = $this->authRepository->social_login($socialUser, $provider);
        
        Auth::guard('customer')->login($user);
        echo '<script>window.location.href="/dashboard"</script>';
    }

    public function index()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('dashboard');
        }

        return $this->authRepository->customer_login_form();
    }
    
    public function forgotPassword()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('dashboard');
        }

        return $this->authRepository->customer_forgot_password_form();
    }

    public function login(Request $request)
    {
        $guard = $this->authRepository->login($request, 'customer');

        if(isset($guard['status']) && $guard['status'] === false) {
            return response()->json([
                'status' => false, 
                'message' => $guard['message']
            ]);
        }

        if ($guard) {
            $request->session()->regenerate();
            return response()->json([
                'status' => true, 
                'goto' => route('dashboard'),
                'message' => "Login successfully"
            ]);
        }

        return response()->json([
            'status' => false, 
            'message' => "The provided credentials do not match our records"
        ]);
    }

    public function logout()
    {
        // Helpers::logout('admin');
        $this->authRepository->logout('customer');  
        
        return response()->json([
            'status' => true, 
            'goto' => route('home'),
            'message' => "Logout successful"
        ]);
    }

    public function pcBuilder()
    {
        return view('frontend.pc-builder');
    }

    

}
