<?php

namespace App\Repositories;

use DataTables;
use App\Models\BrandType;
use App\Repositories\Interface\BrandTypeRepositoryInterface;

class BrandTypeRepository implements BrandTypeRepositoryInterface
{
    public function getAllBrandTypes()
    {
        return BrandType::all();
    }

    public function getAllBrandTypesByBrandId($brandId)
    {
        return BrandType::select('id', 'name')->where('brand_id', $brandId)->where('status', 1)->orderBy('name', 'ASC')->get();
    }

    public function dataTable()
    {
        $models = $this->getAllBrandTypes();
            return Datatables::of($models)
                ->addIndexColumn()
                ->editColumn('brand', function ($model) {
                    return $model->brand ? $model->brand->name : '';
                })
                ->editColumn('status', function ($model) {
                    $checked = $model->status == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch"><input data-url="' . route('admin.brand_type.status', $model->id) . '" class="form-check-input" type="checkbox" role="switch" name="status" id="status' . $model->id . '" ' . $checked . ' data-id="' . $model->id . '"></div>';
                })
                ->editColumn('featured', function ($model) {
                    $featured = $model->is_featured == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch"><input data-url="' . route('admin.brand_type.featured', $model->id) . '" class="form-check-input" type="checkbox" role="switch" name="status" id="status' . $model->id . '" ' . $featured . ' data-id="' . $model->id . '"></div>';
                })
                ->addColumn('action', function ($model) {
                    return view('backend.brand-type.action', compact('model'));
                })
                ->rawColumns(['action', 'status', 'featured', 'brand'])
                ->make(true);
    }

    public function findBrandTypeById($id)
    {
        return BrandType::find($id);
    }

    public function createBrandType($data)
    {
        BrandType::create([
            'name'                  => $data->name,
            'status'                => $data->status,
            'brand_id'              => $data->brand_id,
            'is_featured'           => $data->is_featured,
            'related_categories'    => $data->related_categories
        ]);

        return response()->json(['status' => true, 'load' => true, 'message' => 'Brand type created successfully']);
    }

    public function updateBrandType($id, $data)
    {
        $brandType = BrandType::findOrFail($id);

        $brandType->name                = $data->name;
        $brandType->status              = $data->status;
        $brandType->brand_id            = $data->brand_id;
        $brandType->is_featured         = $data->is_featured;
        $brandType->related_categories  = $data->related_categories;

        $brandType->update();

        return response()->json(['status' => true, 'load' => true, 'message' => 'Brand type updated successfully.']);
    }

    public function deleteBrandType($id)
    {
        $brandType = BrandType::findOrFail($id);
        return $brandType->delete();
    }

    public function updateStatus($request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $brandType = BrandType::find($id);

        if (!$brandType) {
            return response()->json(['success' => false, 'message' => 'Brand type not found.'], 404);
        }

        $brandType->status = $request->input('status');
        $brandType->save();

        return response()->json(['success' => true, 'message' => 'Brand type status updated successfully.']);
    }

    public function updateFeatured($request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);

        $brandType = BrandType::find($id);

        if (!$brandType) {
            return response()->json(['success' => false, 'message' => 'Brand type not found.'], 404);
        }

        $brandType->is_featured = $request->input('status');
        $brandType->save();

        return response()->json(['success' => true, 'message' => 'Brand type feature status updated successfully.']);
    }
}