<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesNPermissionController extends Controller
{
    public function getRoles()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('rolesNpermissions.role', compact('roles', 'permissions'));
    }
    public function getPermissions()
    {
        $permissions = Permission::with('roles')->get();

        return view('rolesNpermissions.permission', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $permissions = $request->permissions;

        if (isset($permissions))

            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }

        return back()->with(
            'sucecss',
            'Successfully created a Role'
        );
    }

    public function storePermission(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return back()->with('success', 'Successfully created a Permission');
    }

    public function editRole($id, Request $request)
    {
        $role = Role::where('id', $id)->first();

        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $permissions = $request->permissions;

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return back()->with('success', "Successfully Updated a role");
    }

    public function destroyRole($id)
    {
        $role = Role::where('id', $id);

        if (isset($role)) {
            $role->delete();
        }

        return back()->with('success', 'Successfully Deleted the role');
    }
}
