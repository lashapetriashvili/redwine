<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        $news = self::customRow('redwine', 'მთავარი გვერდი');
        $news->fill([
            'link'   => '/redwine',
            'icon'   => 'dashboard',
            'parent' => 0,
            'sort'   => 0,
        ])->save();

        $news = self::customRow('redwine', 'პოსტები');
        $news->fill([
            'link'   => '/redwine/page/posts',
            'icon'   => 'library_books',
            'parent' => 0,
            'sort'   => 1,
        ])->save();

        $news = self::customRow('redwine', 'გვერდები');
        $news->fill([
            'link'   => '/redwine/page/pages',
            'icon'   => 'fa fa-file-text',
            'parent' => 0,
            'sort'   => 2,
        ])->save();

        $news = self::customRow('redwine', 'კატეგორიები');
        $news->fill([
            'link'   => '/redwine/page/categories',
            'icon'   => 'content_copy',
            'parent' => 0,
            'sort'   => 3,
        ])->save();

        $news = self::customRow('redwine', 'მენიუ');
        $news->fill([
            'link'   => '/redwine/menu/table',
            'icon'   => 'fa fa-bars',
            'parent' => 0,
            'sort'   => 4,
        ])->save();

        $news = self::customRow('redwine', 'უფლებები');
        $news->fill([
            'link'   => '/redwine/permission/table',
            'icon'   => 'fa fa-lock',
            'parent' => 0,
            'sort'   => 5,
        ])->save();

        $news = self::customRow('redwine', 'მომხმარებელი');
        $news->fill([
            'link'   => '/redwine/page/users',
            'icon'   => 'person',
            'parent' => 0,
            'sort'   => 6,
        ])->save();

        $news = self::customRow('redwine', 'მონაცემთა ბაზა');
        $news->fill([
            'link'   => '/redwine/database/table',
            'icon'   => 'fa fa-cloud',
            'parent' => 0,
            'sort'   => 7,
        ])->save();

        $news = self::customRow('redwine', 'პარამეტრები');
        $news->fill([
            'link'   => '/redwine/page/settings',
            'icon'   => 'fa fa-cog',
            'parent' => 0,
            'sort'   => 8,
        ])->save();

        $news = self::customRow('footer redwine', 'უფლებები');
        $news->fill([
            'link'   => '/redwine/permission/table',
            'icon'   => null,
            'parent' => 0,
            'sort'   => 2,
        ])->save();

        $news = self::customRow('footer redwine', 'მომხმარებელი');
        $news->fill([
            'link'   => '/redwine/page/users',
            'icon'   => null,
            'parent' => 0,
            'sort'   => 3,
        ])->save();

        $news = self::customRow('footer redwine', 'მენიუ');
        $news->fill([
            'link'   => '/redwine/menu/table',
            'icon'   => null,
            'parent' => 0,
            'sort'   => 1,
        ])->save();

        $news = self::customRow('footer redwine', 'მონაცემთა ბაზა');
        $news->fill([
            'link'   => '/redwine/database/table',
            'icon'   => null,
            'parent' => 0,
            'sort'   => 4,
        ])->save();
    }

    static function customRow($menuName, $label)
    {
        return Menu::firstOrNew([
            'menu_name' => $menuName,
            'label'  => $label,
        ]);
    }
}
