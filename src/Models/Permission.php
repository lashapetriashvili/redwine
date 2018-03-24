<?php

namespace Redwine\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public static function generateFor($table_name)
    {
        if ($table_name == 'admin') {
            self::firstOrCreate(['key' => 'browse_'.$table_name, 'key_name' => 'browse', 'table_name' => $table_name]);
        } elseif ($table_name == 'custom page') {
            self::firstOrCreate(['key' => 'browse_custom_page', 'key_name' => 'browse', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'read_custom_page', 'key_name' => 'read', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'edit_custom_page', 'key_name' => 'edit', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'add_custom_page', 'key_name' => 'add', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'delete_custom_page', 'key_name' => 'delete', 'table_name' => $table_name]);
        } else {
            self::firstOrCreate(['key' => 'browse_'.$table_name, 'key_name' => 'browse', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'read_'.$table_name, 'key_name' => 'read', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'edit_'.$table_name, 'key_name' => 'edit', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'add_'.$table_name, 'key_name' => 'add', 'table_name' => $table_name]);
            self::firstOrCreate(['key' => 'delete_'.$table_name, 'key_name' => 'delete', 'table_name' => $table_name]);
        }
    }
}
