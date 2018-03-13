<?php

namespace Redwine\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MenusTableMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        if (!Schema::hasTable('menus')) {
            Schema::create('menus', function (Blueprint $table) {

                $table->increments('id');
                $table->string('label');
                $table->string('link')->nullable();
                $table->string('icon')->nullable();
                $table->string('menu_name')->nullable();
                $table->integer('parent')->nullable();
                $table->integer('sort')->nullable();
                $table->timestamps();
            });
        }
    }
}
