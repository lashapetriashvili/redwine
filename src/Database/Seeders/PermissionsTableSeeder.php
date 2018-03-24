<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\Permission;
use Redwine\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        Permission::generateFor('admin');
        Permission::generateFor('database');
        Permission::generateFor('custom page');
        Permission::generateFor('posts');
        Permission::generateFor('categories');
        Permission::generateFor('permission');
        Permission::generateFor('users');
        Permission::generateFor('menu');
        Permission::generateFor('pages');
        Permission::generateFor('settings');

        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );
    }
}
