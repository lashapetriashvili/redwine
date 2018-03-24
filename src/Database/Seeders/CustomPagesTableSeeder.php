<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\CustomPage;

class CustomPagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        $news = CustomPage::firstOrNew(['table_name' => 'posts']);
        $news->fill([
            'model'        => 'Redwine\Models\Post',
            'display_name' => 'პოსტები',
            'icon'         => 'library_books',
        ])->save();

        $news = CustomPage::firstOrNew(['table_name' => 'categories']);
        $news->fill([
            'model'        => 'Redwine\Models\Categories',
            'display_name' => 'კატეგორიები',
            'icon'         => 'content_copy',
        ])->save();

        $news = CustomPage::firstOrNew(['table_name' => 'users']);
        $news->fill([
            'model'        => 'Redwine\Models\User',
            'display_name' => 'მომხმარებელი',
            'icon'         => 'person',
        ])->save();

        $news = CustomPage::firstOrNew(['table_name' => 'pages']);
        $news->fill([
            'model'        => 'Redwine\Models\Pages',
            'display_name' => 'გვერდები',
            'icon'         => 'fa fa-file-text',
        ])->save();

        $news = CustomPage::firstOrNew(['table_name' => 'settings']);
        $news->fill([
            'model'        => 'Redwine\Models\Settings',
            'display_name' => 'პარამეტრები',
            'icon'         => 'fa fa-cog',
        ])->save();
    }
}
