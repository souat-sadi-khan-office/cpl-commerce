<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interface\TaxRepositoryInterface;

class TaxController extends Controller
{
    private $taxRepository;
    
    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->taxRepository->dataTable();
        }

        return view('backend.tax.index');
    }

    public function create()
    {
        return view('backend.tax.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'status'        => 'required'
        ]);

        $this->taxRepository->createTax($data);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Tax created successfully"
        ]);
    }

    public function edit($id)
    {   
        $model = $this->taxRepository->findTaxById($id);
        return view('backend.tax.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'status'        => 'required'
        ]);

        $this->taxRepository->updateTax($id, $data);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Tax updated successfully"
        ]);
    }

    public function destroy($id)
    {
        $this->taxRepository->deleteTax($id);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Tax deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->taxRepository->updateStatus($request, $id);
    }
}
