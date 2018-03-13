<?php

namespace Redwine\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesTableMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {

                $table->increments('id');
                $table->string('name')->unique();
                $table->string('display_name');
                $table->timestamps();
            });
        }
    }
}
