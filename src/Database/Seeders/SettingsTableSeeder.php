<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\Settings;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        $news = Settings::firstOrNew(['name' => 'version']);
        $news->fill([
            'display_name' => 'ვერსია',
            'value'        => '1.0.0',
        ])->save();
    }
}
