<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\Interface\CurrencyRepositoryInterface;

class UserController extends Controller
{
    private $user;
    private $currency;

    public function __construct(
        UserRepositoryInterface $user,
        CurrencyRepositoryInterface $currency
    ) {
        $this->user = $user;
        $this->currency = $currency;
    }

    public function index(Request $request)
    {
        return view('frontend.customer.dashboard');
    }
    
    public function myOrders()
    {
        return view('frontend.customer.my-orders');
    }
    
    public function quotes()
    {
        return view('frontend.customer.quotes');
    }
    
    public function profile()
    {
        $model = $this->user->getCustomerDetails();
        $currencies = $this->currency->getAllActiveCurrencies();

        return view('frontend.customer.profile', compact('model', 'currencies'));
    }

    public function updateProfile(Request $request)
    {
        return $this->user->updateProfile($request);
    }
    
    public function password()
    {
        return view('frontend.customer.password');
    }

    public function updatePassword(Request $request) 
    {
        return $this->user->updatePassword($request);
    }
    
    public function addressBook()
    {
        return view('frontend.customer.address');
    }
    
    public function wishlist()
    {
        $models = $this->user->getUserWishList();
        return view('frontend.customer.wishlist', compact('models'));
    }

    public function destroyWishlist($id)
    {
        return $this->user->removeWishList($id);
    }
    
    public function star_points()
    {
        return view('frontend.customer.star_points');
    }

    public function saved_pc()
    {
        return view('frontend.customer.saved_pc');
    }

    public function transactions()
    {
        return view('frontend.customer.transactions');
    }
}
