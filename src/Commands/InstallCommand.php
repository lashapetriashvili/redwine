<?php

namespace Redwine\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Tebles Migrations & Seeder Namespace
use Redwine\Database\Migrations\UsersTableMigrate;
use Redwine\Database\Seeders\UsersTableSeeder;
use Redwine\Database\Migrations\SettingsTableMigrate;
use Redwine\Database\Seeders\SettingsTableSeeder;
use Redwine\Database\Migrations\CategoriesTableMigrate;
use Redwine\Database\Seeders\CategoriesTableSeeder;
use Redwine\Database\Migrations\CustomPagesTableMigrate;
use Redwine\Database\Seeders\CustomPagesTableSeeder;
use Redwine\Database\Seeders\CustomPagesRowsTableSeeder;
use Redwine\Database\Migrations\RolesTableMigrate;
use Redwine\Database\Seeders\RolesTableSeeder;
use Redwine\Database\Migrations\MenusTableMigrate;
use Redwine\Database\Seeders\MenusTableSeeder;
use Redwine\Database\Migrations\PagesTableMigrate;
use Redwine\Database\Migrations\PagesTableSeeder;
use Redwine\Database\Migrations\PostsTableMigrate;
use Redwine\Database\Migrations\PostsTableSeeder;
use Redwine\Database\Migrations\PermissionsTableMigrate;
use Redwine\Database\Seeders\PermissionsTableSeeder;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'redwine:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Redwine Admin package';

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {

        $this->info('Publishing the Redwine assets and uploads folder');
        
        $this->call('vendor:publish', ['--tag' => 'public_assets']);
        $this->call('vendor:publish', ['--tag' => 'public_uploads']);

        $this->info('Migrating the database tables into your application');
        // Users Table
        UsersTableMigrate::migrate();
        UsersTableSeeder::run();
        
        // Settings Table
        SettingsTableMigrate::migrate();
        SettingsTableSeeder::run();

        // Categories Table
        CategoriesTableMigrate::migrate();
        CategoriesTableSeeder::run();
        
        // Custom_pages & Custom_Page_Rows Table
        CustomPagesTableMigrate::migrate();
        CustomPagesTableSeeder::run();
        CustomPagesRowsTableSeeder::run();

        // Roles Table
        RolesTableMigrate::migrate();
        RolesTableSeeder::run();

        // Menus Table
        MenusTableMigrate::migrate();
        MenusTableSeeder::run();

        // Pages & Posts Table
        PagesTableMigrate::migrate();
        PagesTableSeeder::run();
        PostsTableMigrate::migrate();
        PostsTableSeeder::run();

        // Permissions & Permission_Role Table
        PermissionsTableMigrate::migrate();
        PermissionsTableSeeder::run();

        $this->info('Redwine Admin package successfully installed');
        $this->info('E-mail: admin@admin.com');
        $this->info('Password: 123');
    }
}
