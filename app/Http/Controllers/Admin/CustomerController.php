<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Repositories\Interface\CustomerRepositoryInterface;
use App\Repositories\Interface\CurrencyRepositoryInterface;

class CustomerController extends Controller
{
    private $customerRepository;
    private $currencyRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CurrencyRepositoryInterface $currencyRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            return $this->customerRepository->dataTable();
        }

        return view('backend.customers.index');
    }

    public function create()
    {
        $currencies = $this->currencyRepository->getAllActiveCurrencies();
        return view('backend.customers.create', compact('currencies'));
    }

    public function store(CustomerRequest $request)
    {
        return $this->customerRepository->createCustomer($request);
    }

    public function show()
    {
        
    }

    public function edit($id)
    {
        $currencies = $this->currencyRepository->getAllActiveCurrencies();
        $model = $this->customerRepository->findCustomerById($id);
        return view('backend.customers.edit', compact('model', 'currencies'));
    }

    public function update(CustomerRequest $request, $id)
    {
        return $this->customerRepository->updateCustomer($id, $request);
    }

    public function destroy($id)
    {
        $this->customerRepository->deleteCustomer($id);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Customer deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->customerRepository->updateStatus($request, $id);
    }
}