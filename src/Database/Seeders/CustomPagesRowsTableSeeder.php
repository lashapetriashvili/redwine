<?php

namespace Redwine\Database\Seeders;

use Illuminate\Database\Seeder;
use Redwine\Models\CustomPage;
use Redwine\Models\CustomPageRow;

class CustomPagesRowsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public static function run()
    {
        $news = self::customRow('posts', 'id');
        $news->fill([
            'type'          => null,
            'display_name'  => 'ID',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 1,
        ])->save();

        $news = self::customRow('posts', 'title');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'სათაური',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 2,
        ])->save();

        $news = self::customRow('posts', 'slug');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'იარლიყი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true,
	"slug": {
		"number": 35,
		"get": "title"
    }
}',
            'position'      => 3,
        ])->save();

        $news = self::customRow('posts', 'author_id');
        $news->fill([
            'type'          => 'hidden',
            'display_name'  => 'ავტორი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"value": "get_user_id",
	"display": "name"
}',
            'position'      => 4,
        ])->save();

        $news = self::customRow('posts', 'category_id');
        $news->fill([
            'type'          => 'select',
            'display_name'  => 'კატეგორია',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true,
	"value": {
		"model": "Redwine\\\Models\\\Categories",
		"option": "name",
		"value": "id"
	},
	"display": {
		"model": "Redwine\\\Models\\\Categories",
		"where": "id",
		"view": "name"
	}
}',
            'position'      => 5,
        ])->save();

        $news = self::customRow('posts', 'body');
        $news->fill([
            'type'          => 'textarea (editor)',
            'display_name'  => 'აღწერა',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 6,
        ])->save();
	    
	$news = self::customRow('posts', 'excerpt');
        $news->fill([
            'type'          => 'tinytextarea (editor)',
            'display_name'  => 'მოკლე აღწერა',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 7,
        ])->save();

        $news = self::customRow('posts', 'image');
        $news->fill([
            'type'          => 'image',
            'display_name'  => 'სურათი',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 8,
        ])->save();

        $news = self::customRow('posts', 'seo_title');
        $news->fill([
            'type'          => 'seo text',
            'display_name'  => 'SEO სათაური',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => null,
            'position'      => 9,
        ])->save();

        $news = self::customRow('posts', 'meta_description');
        $news->fill([
            'type'          => 'seo textarea',
            'display_name'  => 'SEO აღწერა',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => null,
            'position'      => 10,
        ])->save();

        $news = self::customRow('posts', 'meta_keywords');
        $news->fill([
            'type'          => 'seo tag',
            'display_name'  => 'საკვანძო სიტყვები',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => null,
            'position'      => 11,
        ])->save();

        $news = self::customRow('posts', 'status');
        $news->fill([
            'type'          => 'checkbox',
            'display_name'  => 'სტატუსი',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"checked": true
}',
            'position'      => 12,
        ])->save();

        $news = self::customRow('posts', 'created_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'შექმინს დრო',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 13,
        ])->save();

        $news = self::customRow('posts', 'updated_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'განახლების დრო',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 14,
        ])->save();

        $news = self::customRow('categories', 'id');
        $news->fill([
            'type'          => null,
            'display_name'  => 'ID',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 1,
        ])->save();

        $news = self::customRow('categories', 'name');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'სახელი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 2,
        ])->save();

        $news = self::customRow('categories', 'slug');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'იარლიყი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true,
	"slug": {
		"number": 35,
		"get": "name"
	}
}',
            'position'      => 3,
        ])->save();

        $news = self::customRow('categories', 'created_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'შექმნის დრო',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 4,
        ])->save();

        $news = self::customRow('categories', 'updated_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'განახლების დრო',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 5,
        ])->save();

        $news = self::customRow('users', 'id');
        $news->fill([
            'type'          => null,
            'display_name'  => 'ID',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 1,
        ])->save();

        $news = self::customRow('users', 'role_id');
        $news->fill([
            'type'          => 'select',
            'display_name'  => 'უფლება',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true,
	"value": {
		"model": "Redwine\\\Models\\\Role",
		"option": "name",
		"value": "id"
    },
	"display": {
		"model": "Redwine\\\Models\\\Role",
		"where": "id",
		"view": "name"
	}
}',
            'position'      => 2,
        ])->save();

        $news = self::customRow('users', 'email');
        $news->fill([
            'type'          => 'email',
            'display_name'  => 'მაილი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true,
	"unique": true
}',
            'position'      => 3,
        ])->save();

        $news = self::customRow('users', 'name');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'სახელი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 4,
        ])->save();

        $news = self::customRow('users', 'password');
        $news->fill([
            'type'          => 'password',
            'display_name'  => 'პაროლი',
            'column_browse' => 0,
            'column_read'   => 0,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 5,
        ])->save();

        $news = self::customRow('users', 'remember_token');
        $news->fill([
            'type'          => null,
            'display_name'  => null,
            'column_browse' => 0,
            'column_read'   => 0,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 6,
        ])->save();

        $news = self::customRow('users', 'created_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'შექმნის დრო',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 7,
        ])->save();

        $news = self::customRow('users', 'updated_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'განახლების დრო',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 8,
        ])->save();

        $news = self::customRow('pages', 'id');
        $news->fill([
            'type'          => null,
            'display_name'  => 'ID',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 1,
        ])->save();

        $news = self::customRow('pages', 'title');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'სათაური',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 2,
        ])->save();

        $news = self::customRow('pages', 'slug');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'იარლიყი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true,
	"slug": {
		"number": 35,
		"get": "title"
	}
}',
            'position'      => 3,
        ])->save();

        $news = self::customRow('pages', 'author_id');
        $news->fill([
            'type'          => 'hidden',
            'display_name'  => 'ავტორი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"value": "get_user_id",
	"display": "name"
}',
            'position'      => 4,
        ])->save();

        $news = self::customRow('pages', 'body');
        $news->fill([
            'type'          => 'textarea (editor)',
            'display_name'  => 'აღწერა',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 5,
        ])->save();

        $news = self::customRow('pages', 'image');
        $news->fill([
            'type'          => 'image',
            'display_name'  => 'სურათი',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 7,
        ])->save();

        $news = self::customRow('pages', 'seo_title');
        $news->fill([
            'type'          => 'seo text',
            'display_name'  => 'SEO სათაური',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => null,
            'position'      => 8,
        ])->save();

        $news = self::customRow('pages', 'meta_description');
        $news->fill([
            'type'          => 'seo textarea',
            'display_name'  => 'SEO აღწერა',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => null,
            'position'      => 9,
        ])->save();

        $news = self::customRow('pages', 'meta_keywords');
        $news->fill([
            'type'          => 'seo tag',
            'display_name'  => 'საკვანძო სიტყვები',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => null,
            'position'      => 10,
        ])->save();

        $news = self::customRow('pages', 'status');
        $news->fill([
            'type'          => 'checkbox',
            'display_name'  => 'სტატუსი',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"checked": true
}',
            'position'      => 11,
        ])->save();

        $news = self::customRow('pages', 'created_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'შექმნის დრო',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 12,
        ])->save();

        $news = self::customRow('pages', 'updated_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'განახლების დრო',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 13,
        ])->save();

        $news = self::customRow('settings', 'id');
        $news->fill([
            'type'          => null,
            'display_name'  => 'ID',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 1,
        ])->save();

        $news = self::customRow('settings', 'name');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'სახელი',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true,
	"unique": true
}',
            'position'      => 2,
        ])->save();

        $news = self::customRow('settings', 'display_name');
        $news->fill([
            'type'          => 'text',
            'display_name'  => 'სრული დასახელება',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"required": true
}',
            'position'      => 3,
        ])->save();

        $news = self::customRow('settings', 'value');
        $news->fill([
            'type'          => 'textarea',
            'display_name'  => 'მნიშვნელობა',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 1,
            'column_add'    => 1,
            'details'       => '{
	"col": "col-md-12",
	"required": true
}',
            'position'      => 4,
        ])->save();

        $news = self::customRow('settings', 'created_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'შექმნის დრო',
            'column_browse' => 1,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 5,
        ])->save();

        $news = self::customRow('settings', 'updated_at');
        $news->fill([
            'type'          => null,
            'display_name'  => 'განახლების დრო',
            'column_browse' => 0,
            'column_read'   => 1,
            'column_edit'   => 0,
            'column_add'    => 0,
            'details'       => null,
            'position'      => 6,
        ])->save();
    }

    static function customRow($page, $field)
    {
        $customPage = CustomPage::where('table_name', $page)->select('id')->first();

        return CustomPageRow::firstOrNew([
            'custom_page_id' => $customPage->id,
            'field'          => $field,
        ]);
    }
}
