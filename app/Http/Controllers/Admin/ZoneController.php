<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interface\ZoneRepositoryInterface;

class ZoneController extends Controller
{
    private $zoneRepository;

    public function __construct(ZoneRepositoryInterface $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->zoneRepository->dataTable();
        }

        return view('backend.zone.index');
    }

    public function create()
    {
        return view('backend.zone.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $this->zoneRepository->createZone($data);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Zone created successfully"
        ]);
    }

    public function getZoneInformationById(Request $request)
    {
        $zoneId = $request->zone_id;
        return $this->zoneRepository->findZoneById($zoneId);
    }

    public function edit($id)
    {
        $model = $this->zoneRepository->findZoneById($id);
        return view('backend.zone.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $this->zoneRepository->updateZone($id, $data);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Zone updated successfully"
        ]);
    }

    public function destroy($id)
    {
        $this->zoneRepository->deleteZone($id);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Admin deleted successfully"
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        return $this->zoneRepository->updateStatus($request, $id);
    }
}
