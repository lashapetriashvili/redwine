<?php

namespace Redwine\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostsTableMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {

                $table->increments('id');
                $table->string('slug')->unique();
                $table->integer('author_id');
                $table->integer('category_id')->nullable();
                $table->string('title')->nullable();
                $table->string('seo_title')->nullable();
                $table->text('excerpt')->nullable();
                $table->text('body')->nullable();
                $table->text('image')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
    }
}
