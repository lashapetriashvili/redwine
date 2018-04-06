<?php

namespace Redwine\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redwine\Facades\Redwine;
use Redwine\Models\Role;
use Redwine\models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        Redwine::permissionFail('browse_permission');

        $roles = Role::orderBy('id', 'desc')->paginate(10);

        return view('redwine::permission.table', compact('roles'));
    }

    public function viewAdd()
    {
        Redwine::permissionFail('add_permission');

        $permissions    = Permission::select('table_name')->get();
        $array          = [];
        $new_permission = [];

        foreach ($permissions as $key => $permission) {
            if (!in_array($permission->table_name, $array)) {
                $array[$key]          = $permission->table_name;
                $new_permission[$key] = $permission->table_name;
            }
        }

        return view('redwine::permission.add', [
            'permissions' => $new_permission,
            'controller'  => $this
        ]);
    }

    public function add(Request $request)
    {
        Redwine::permissionFail('edit_permission');

        $role = new Role;

        $role->name         = $request->name;
        $role->display_name = $request->display_name;

        $role->save();

        $permissions = Permission::select('id', 'key')->get();

        foreach ($permissions as $permission) {
            if ($request[$permission->key] == 'on') {
                DB::table('permission_role')->insert([
                    'permission_id' => $permission->id,
                    'role_id'       => $role->id
                ]);
            }
        }
        
        return redirect('/redwine/permission/table');
    }

    public function viewEdit($id)
    {
        Redwine::permissionFail('edit_permission');

        $permissions = Permission::select('table_name')->get();
        $array = [];
        $new_permission = [];

        foreach ($permissions as $key => $permission) {
            if (!in_array($permission->table_name, $array)) {
                $array[$key]          = $permission->table_name;
                $new_permission[$key] = $permission->table_name;
            }
        }

        $permission_role = [];

        $roles = DB::table('permission_role')->where('role_id', $id)->get();

        foreach ($roles as $key => $role) {
            $permission_role[$key] = $role->permission_id;
        }

        $role = Role::where('id', $id)->get();

        return view('redwine::permission.edit', [
            'permissions'     => $new_permission,
            'id'              => $id,
            'controller'      => $this,
            'permission_role' => $permission_role,
            'role'            => $role
        ]);
    }

    public function getKey($table_name)
    {
        $permissions = Permission::where('table_name', $table_name)->get();

        return $permissions;
    }

    public function edit($id, Request $request)
    {
        Redwine::permissionFail('edit_permission');

        DB::table('permission_role')->where('role_id', $id)->delete();

        $role = Role::find($id);

        $role->name         = $request->name;
        $role->display_name = $request->display_name;

        $role->save();

        $permissions = Permission::select('id', 'key')->get();

        foreach ($permissions as $permission) {
            if ($request[$permission->key] == 'on') {
                DB::table('permission_role')->insert([
                    'permission_id' => $permission->id,
                    'role_id'       => $id
                ]);
            }
        }
        
        return redirect('/redwine/permission/table');
    }

    public function delete($id)
    {
        Redwine::permissionFail('delete_permission');

        DB::table('permission_role')->where('role_id', $id)->delete();

        $delete = Role::find($id)->delete();
        
        return response()->json($delete);
    }
}
