<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\Categories;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        $news = Categories::firstOrNew(['name' => 'წითელი ღვინო']);
        $news->fill([
            'slug' => 'red_wine'
        ])->save();
    }
}
