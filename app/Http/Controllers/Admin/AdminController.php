<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Interface\BrandRepositoryInterface;
use App\Repositories\Interface\CustomerRepositoryInterface;
use App\Repositories\Interface\CategoryRepositoryInterface;

class AdminController extends Controller
{
    private $customer;
    private $category;
    private $brand;

    public function __construct(
        BrandRepositoryInterface $brand,
        CustomerRepositoryInterface $customer,
        CategoryRepositoryInterface $category,
    ) {
        $this->customer = $customer;
        $this->category = $category;
        $this->brand = $brand;
    }

    public function index()
    {
        $number_of_order = 0;
        $number_of_brand = $this->brand->getAllBrands()->count();
        $number_of_customer = $this->customer->getAllCustomers()->count();
        $number_of_category = $this->category->getAllCategories()->count();

        return view('backend.dashboard', compact('number_of_brand', 'number_of_category', 'number_of_customer', 'number_of_order'));
    }
}
