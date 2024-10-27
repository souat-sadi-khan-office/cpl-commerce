<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interface\AuthRepositoryInterface;

class RegisterController extends Controller
{

    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function index()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('dashboard');
        }

        return $this->authRepository->customer_register_form();
    }

    public function register(Request $request)
    {
        $registerResponse = $this->authRepository->registerUser($request);
        if(!$registerResponse['status']) {
            return response()->json([
                'status' => false, 
                'validator' => $registerResponse['message']
            ]);
        }

        
        $guard = $this->authRepository->login($request, 'customer');
        if ($guard) {
            $request->session()->regenerate();
            return response()->json([
                'status' => true, 
                'goto' => route('dashboard'),
                'message' => "Registration successful"
            ]);
        }
    }
}
