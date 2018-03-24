<?php

namespace Redwine\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomPagesTableMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        if (!Schema::hasTable('custom_pages')) {
            Schema::create('custom_pages', function (Blueprint $table) {

                $table->increments('id');
                $table->string('table_name');
                $table->string('model')->nullable();
                $table->string('display_name')->nullable();
                $table->string('icon')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('custom_page_rows')) {
            Schema::create('custom_page_rows', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('custom_page_id')->unsigned();
                $table->string('field');
                $table->string('type')->nullable();
                $table->string('display_name')->nullable();
                $table->boolean('column_browse')->default(true);
                $table->boolean('column_read')->default(true);
                $table->boolean('column_edit')->default(true);
                $table->boolean('column_add')->default(true);
                $table->text('details')->nullable();
                $table->integer('position')->nullable();
                $table->timestamps();

                $table->foreign('custom_page_id')->references('id')->on('custom_pages')
                    ->onUpdate('cascade')->onDelete('cascade');
            });
        }
    }
}
