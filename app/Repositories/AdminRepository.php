<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Repositories\Interface\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function getAllAdmins()
    {
        return Admin::select('id', 'name', 'email', 'phone', 'updated_at')->get();
    }

    public function getAdminById($id)
    {
        return Admin::findOrFail($id);
    }

    public function createAdmin($data)
    {
        $data['password'] = Hash::make($data['password']);
        
        $role = Role::find($data['roles']);
        $admin = Admin::create($data);

        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);

        return 1;
    }

    public function updateAdmin($id, array $data)
    {
        $admin = Admin::findOrFail($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $admin->update($data);

        if ($admin->roles->toArray()[0]['id'] != $data['roles']) {

            $role = Role::findOrFail($data['roles']);
            $admin->removeRole($role->name);

            $admin->assignRole($role->name);
        }

        return $admin;
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
    }
}