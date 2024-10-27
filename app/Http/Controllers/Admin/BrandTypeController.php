<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandTypeRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Interface\BrandTypeRepositoryInterface;

class BrandTypeController extends Controller
{
    private $brandTypeRepository;

    public function __construct(BrandTypeRepositoryInterface $brandTypeRepository)
    {
        $this->brandTypeRepository = $brandTypeRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            return $this->brandTypeRepository->dataTable();
        }

        return view('backend.brand-type.index');
    }

    public function create()
    {
        $brands = Brand::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('backend.brand-type.create', compact('brands'));
    }

    public function store(BrandTypeRequest $request)
    {
        return $this->brandTypeRepository->createBrandType($request);
    }

    public function edit($id)
    {
        $brands = Brand::where('status', 1)->orderBy('name', 'ASC')->get();
        $model = $this->brandTypeRepository->findBrandTypeById($id);
        return view('backend.brand-type.edit', compact('model', 'brands'));
    }

    public function update(BrandTypeRequest $request, $id)
    {
        return $this->brandTypeRepository->updateBrandType($id, $request);
    }

    public function destroy($id)
    {
        $this->brandTypeRepository->deleteBrandType($id);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Brand deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->brandTypeRepository->updateStatus($request, $id);
    }

    public function updateFeatured(Request $request, $id)
    {
        return $this->brandTypeRepository->updateFeatured($request, $id);
    }
}
