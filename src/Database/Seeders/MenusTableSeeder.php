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
        $news = self::customRow('redwine', '{redwine.menu.home page}');
        $news->fill([
            'link'   => '/redwine',
            'icon'   => 'dashboard',
            'parent' => 0,
            'sort'   => 0,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.post}');
        $news->fill([
            'link'   => '/redwine/page/posts',
            'icon'   => 'library_books',
            'parent' => 0,
            'sort'   => 1,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.page}');
        $news->fill([
            'link'   => '/redwine/page/pages',
            'icon'   => 'fa fa-file-text',
            'parent' => 0,
            'sort'   => 2,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.categorie}');
        $news->fill([
            'link'   => '/redwine/page/categories',
            'icon'   => 'content_copy',
            'parent' => 0,
            'sort'   => 3,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.language}');
        $news->fill([
            'link'   => '/redwine/lang/table',
            'icon'   => 'language',
            'parent' => 0,
            'sort'   => 4,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.menu}');
        $news->fill([
            'link'   => '/redwine/menu/table',
            'icon'   => 'fa fa-bars',
            'parent' => 0,
            'sort'   => 5,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.role}');
        $news->fill([
            'link'   => '/redwine/permission/table',
            'icon'   => 'fa fa-lock',
            'parent' => 0,
            'sort'   => 6,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.user}');
        $news->fill([
            'link'   => '/redwine/page/users',
            'icon'   => 'person',
            'parent' => 0,
            'sort'   => 7,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.database}');
        $news->fill([
            'link'   => '/redwine/database/table',
            'icon'   => 'fa fa-cloud',
            'parent' => 0,
            'sort'   => 8,
        ])->save();

        $news = self::customRow('redwine', '{redwine.menu.setting}');
        $news->fill([
            'link'   => '/redwine/page/settings',
            'icon'   => 'fa fa-cog',
            'parent' => 0,
            'sort'   => 9,
        ])->save();

        $news = self::customRow('footer redwine', '{redwine.menu.role}');
        $news->fill([
            'link'   => '/redwine/permission/table',
            'icon'   => null,
            'parent' => 0,
            'sort'   => 2,
        ])->save();

        $news = self::customRow('footer redwine', '{redwine.menu.user}');
        $news->fill([
            'link'   => '/redwine/page/users',
            'icon'   => null,
            'parent' => 0,
            'sort'   => 3,
        ])->save();

        $news = self::customRow('footer redwine', '{redwine.menu.menu}');
        $news->fill([
            'link'   => '/redwine/menu/table',
            'icon'   => null,
            'parent' => 0,
            'sort'   => 1,
        ])->save();

        $news = self::customRow('footer redwine', '{redwine.menu.database}');
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
