<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        $news = User::firstOrNew(['name' => 'admin']);
        $news->fill([
            'role_id'  => 1,
            'email'    => 'admin@admin.com',
            'password' => Hash::make(123),
        ])->save();
    }
}
