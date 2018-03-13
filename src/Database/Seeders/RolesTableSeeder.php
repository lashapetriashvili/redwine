<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        $news = Role::firstOrNew(['name' => 'admin']);
        $news->fill([
            'display_name' => 'ადმინისტრატორი'
        ])->save();
    }
}
