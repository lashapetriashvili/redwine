<?php

namespace Redwine\Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersTableMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function migrate()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {

                $table->increments('id');
                $table->integer('role_id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('lang');
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            Schema::table('users', function ($table) {

                if (!Schema::hasColumn('users', 'id')) {
                    $table->increments('id');
                }

                if (!Schema::hasColumn('users', 'role_id')) {
                    $table->integer('role_id')->after('id');
                }

                if (!Schema::hasColumn('users', 'name')) {
                    $table->string('name')->after('role_id');
                }

                if (!Schema::hasColumn('users', 'email')) {
                    $table->string('email')->unique()->after('name');
                }

                if (!Schema::hasColumn('users', 'password')) {
                    $table->string('password')->after('email');
                }

                if (!Schema::hasColumn('users', 'lang')) {
                    $table->string('lang')->after('password');
                }

                if (!Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken();
                }

                if (!Schema::hasColumn('users', 'created_at') && !Schema::hasColumn('users', 'updated_at')) {
                    $table->timestamps();
                }

                if (!Schema::hasColumn('users', 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }

                if (!Schema::hasColumn('users', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
            });
        }
    }
}
