<?php

namespace App\Repositories;

use DataTables;
use App\CPU\Images;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interface\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAllCustomers()
    {
        return User::orderBy('id', 'DESC')->get();
    }

    public function dataTable()
    {
        $models = $this->getAllCustomers();
        return Datatables::of($models)
            ->addIndexColumn()
            ->editColumn('avatar', function($model) {
                if($model->provider_name == 'google' || $model->provider_name == 'facebook') {
                    $image = Images::show($model->avatar);
                } else {
                    $image = '<img src="'. asset('pictures/user.png') .'" alt="'. $model->name .'">';
                }

                return $image;
            })
            ->editColumn('currency', function ($model) {
                return $model->currency->name;
            })
            ->editColumn('created_at', function ($model) {
                return get_system_date($model->created_at) . ' '. get_system_time($model->created_at);
            })
            ->editColumn('status', function ($model) {
                $checked = $model->status == 1 ? 'checked' : '';
                return '<div class="form-check form-switch"><input data-url="' . route('admin.customer.status', $model->id) . '" class="form-check-input" type="checkbox" role="switch" name="status" id="status' . $model->id . '" ' . $checked . ' data-id="' . $model->id . '"></div>';
            })
            ->addColumn('action', function ($model) {
                return view('backend.customers.action', compact('model'));
            })
            ->editColumn('provider', function($model) {
                return $model->provider_name == null ? 'Normal Login User': ucfirst($model->provider_name) . ' User';
            })
            ->rawColumns(['action', 'provider', 'avatar', 'status', 'currency'])
            ->make(true);
    }

    public function findCustomerById($id)
    {
        return User::findOrFail($id);
    }

    public function createCustomer($data)
    {
        $brand = User::create([
            'currency_id' => $data->currency_id,
            'name' => $data->name,
            'email' => $data->email,
            'avatar' => "user.png",
            'password' => Hash::make($data->password),
            'status' => $data->status
        ]);

        $json = ['status' => true, 'goto' => route('admin.customer.index'), 'message' => 'Customer created successfully'];
        return response()->json($json);
    }

    public function updateCustomer($id, $data)
    {
        $customer = User::findOrFail($id);
        $customer->name = $data->name;
        $customer->currency_id = $data->currency_id;
        $customer->status = $data->status;
        $customer->email = $data->email;
        if($data->password != ''){
            $customer->password = Hash::make($data->password);
        }
        $customer->update();

        return response()->json(['status' => true, 'goto' => route('admin.customer.index'), 'message' => 'Customer updated successfully.']);
    }

    public function deleteCustomer($id)
    {
        $customer = User::findOrFail($id);
        return $customer->delete();
    }

    public function updateStatus($request, $id) 
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $customer = User::find($id);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }

        $customer->status = $request->input('status');
        $customer->save();

        return response()->json(['success' => true, 'message' => 'Customer status updated successfully.']);
    }
}