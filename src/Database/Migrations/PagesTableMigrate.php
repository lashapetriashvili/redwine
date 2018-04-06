<?php

namespace Redwine\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagesTableMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        if (!Schema::hasTable('pages')) {
            Schema::create('pages', function (Blueprint $table) {

                $table->increments('id');
                $table->integer('author_id');
                $table->string('title')->nullable();
                $table->string('slug')->unique();
                $table->text('body')->nullable();
                $table->text('image')->nullable();
                $table->string('seo_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->string('lang')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
    }
}
