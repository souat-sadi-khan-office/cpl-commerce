<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Repositories\Interface\AdminRepositoryInterface;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class StuffController extends Controller
{
    private $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $models = $this->adminRepository->getAllAdmins();
            return Datatables::of($models)
                ->addIndexColumn()
                ->editColumn('role', function($model) {
                    return implode(', ', $model->getRoleNames()->toArray());
                })
                ->addColumn('action', function ($model) {
                    return view('backend.stuff.action', compact('model'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.stuff.index');
    }

    public function show($id)
    {
        $admin = $this->adminRepository->getAdminById($id);
        return view('backend.stuff.show', compact('admin'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('backend.stuff.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'phone' => 'required|string',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|string',
            'allow_changes' => 'nullable|boolean',
            'last_seen' => 'nullable|date',
            'last_login' => 'nullable|date',
            'address' => 'nullable|string',
            'area' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'remember_token' => 'nullable|string',
            'roles' => 'string',
        ]);

        $this->adminRepository->createAdmin($data);
        return response()->json([
            'status' => true, 
            'goto' => route('admin.stuff.index'),
            'message' => "User created successfully"
        ]);
    }

    public function edit($id)
    {
        $model = $this->adminRepository->getAdminById($id);
        $roles = Role::all();
        return view('backend.stuff.edit', compact('model', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'phone' => 'required|string',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|string',
            'allow_changes' => 'nullable|boolean',
            'last_seen' => 'nullable|date',
            'last_login' => 'nullable|date',
            'address' => 'nullable|string',
            'area' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'roles' => 'string',
        ]);

        $this->adminRepository->updateAdmin($id, $data);
        return response()->json([
            'status' => true, 
            'goto' => route('admin.stuff.index'),
            'message' => "User update successfully"
        ]);
    }

    public function destroy($id)
    {
        $this->adminRepository->deleteAdmin($id);

        return response()->json([
            'status' => true, 
            'load' => true,
            'message' => "Admin deleted successfully"
        ]);
    }
}
