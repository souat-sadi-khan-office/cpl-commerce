<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Interface\BrandRepositoryInterface;

class BrandController extends Controller
{
    private $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            return $this->brandRepository->dataTable();
        }

        return view('backend.brands.index');
    }

    public function create()
    {
        return view('backend.brands.create');
    }

    public function store(BrandRequest $request)
    {
        return $this->brandRepository->createBrand($request);
    }

    public function edit($id)
    {
        $model = $this->brandRepository->findBrandById($id);
        return view('backend.brands.edit', compact('model'));
    }

    public function update(BrandRequest $request, $id)
    {
        return $this->brandRepository->updateBrand($id, $request);
    }

    public function destroy($id)
    {
        $this->brandRepository->deleteBrand($id);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Brand deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->brandRepository->updateStatus($request, $id);
    }
    
    public function updateFeatured(Request $request, $id)
    {
        return $this->brandRepository->updateFeatured($request, $id);
    }
}
