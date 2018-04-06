<?php

namespace Redwine\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Redwine\Facades\Redwine;
use Redwine\Database\Types;
use Redwine\Models\CustomPage;
use Redwine\Models\CustomPageRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Redwine\models\Permission;

class DatabaseController extends Controller
{
    public function index()
    {
        Redwine::permissionFail('browse_database');

        $tables = DB::select('SHOW TABLES');

        $columns = ['custom_pages', 'custom_page_rows', 'migrations', 'password_resets', 'permissions', 'permission_role', 'roles', 'menus'];

        $models = [
            'custom_pages'     => 'Redwine\Models\CustomPage',
            'custom_page_rows' => 'Redwine\Models\CustomPageRow',
            'permissions'      => 'Redwine\models\Permission',
            'roles'            => 'Redwine\Models\Role',
            'menus'            => 'Redwine\Models\Menu'
        ];

        return view('redwine::database.table', [
            'tables'     => $tables,
            'controller' => $this,
            'columns'    => $columns,
            'models'     => $models
        ]);
    }

    public function checkPage($table)
    {
        Redwine::permissionFail('read_database');

        $page = CustomPage::select('id')->where('table_name', $table)->first();

        if ($page) {
            $count = CustomPageRow::select('id')->where('custom_page_id', $page->id)->count();

            return $count ? true : false;
        } else {
            return false;
        }
    }

    public function getModel($table)
    {
        redwine::permissionFail('read_database');

        $customPage = CustomPage::select('model')->where('table_name', $table)->first();
         
        return $customPage ? $customPage->model : false;
    }

    public function add()
    {
        Redwine::permissionFail('add_database');

        return view('redwine::database.add');
    }

    public function storeDatabase(Request $request)
    {
        Redwine::permissionFail('add_database');

        $this->validate($request, [
            'name' => 'required'
        ]);

        if (!Schema::hasTable($request->name)) {
            Schema::create($request->name, function (Blueprint $table) use ($request) {

                for ($i = 0; $i < count($request->data); $i++) {
                    Types::columnTypes($request, $table, $i);
                }
            });

            if ($request->getModel == 1) {
                Artisan::call('make:model', [
                    'name' => ucfirst($request->name)
                ]);
            }

            if ($request->getController == 1) {
                Artisan::call('make:controller', [
                    'name' => ucfirst($request->name) . 'Controller'
                ]);
            }

            $customPage = new CustomPage;

            $customPage->table_name = $request->name;
            if ($request->getModel == 1) {
                $customPage->model = "App\\" . ucfirst($request->name);
            }

            $save = $customPage->save();

            return response()->json($save);
        } else {
            return response()->json(false);
        }
    }

    public function delete(Request $Request, $table)
    {
        Redwine::permissionFail('delete_database');

        Schema::dropIfExists($table);

        $page = CustomPage::select('id')->where('table_name', $table)->first();

        if ($page) {
            $count = CustomPageRow::select('id')->where('custom_page_id', $page->id)->count();

            if ($count) {
                CustomPageRow::where('custom_page_id', $page->id)->delete();
            }

            CustomPage::where('table_name', $table)->delete();

            Permission::where('table_name', $table)->delete();
        } else {
            CustomPage::where('table_name', $table)->delete();
        }
    }
}
