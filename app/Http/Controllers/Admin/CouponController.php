<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interface\CouponRepositoryInterface;

class CouponController extends Controller
{
    private $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            return $this->couponRepository->dataTable();
        }

        return view('backend.coupon.index');
    }

    public function create()
    {
        return view('backend.coupon.create');
    }

    public function store(Request $request)
    {
        return $this->couponRepository->create($request);
    }

    public function edit($id)
    {
        $model = $this->couponRepository->find($id);
        return view('backend.coupon.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        return $this->couponRepository->update($id, $request);
    }

    public function destroy($id)
    {
        $this->couponRepository->delete($id);

        return response()->json([
            'status' => true,
            'load' => true,
            'message' => "Coupon deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->couponRepository->updateStatus($request, $id);
    }
}
