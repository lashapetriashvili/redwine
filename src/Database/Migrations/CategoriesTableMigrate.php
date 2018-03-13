<?php

namespace Redwine\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesTableMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {

                $table->increments('id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }
    }
}
