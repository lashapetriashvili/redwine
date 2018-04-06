<?php

namespace Redwine\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Redwine\Facades\Redwine;
use Redwine\Models\CustomPage;
use Redwine\Models\CustomPageRow;
use Redwine\models\Permission;
use File;

class CustomPageController extends Controller
{
    public function index($custompage)
    {
        Redwine::permissionFail('add_custom_page');

        $columns = DB::select('describe ' . $custompage);
        $model   = CustomPage::select('model')->where('table_name', $custompage)->first();
        $model   = $model ? $model->model : null;

        return view('redwine::page.custompage', compact('columns', 'custompage', 'model'));
    }

    public function add(Request $request)
    {
        Redwine::permissionFail('add_custom_page');

        $id = CustomPage::select('id')->where('table_name', $request->page['tableName'])->first();

        if ($id) {
            $customPage = CustomPage::find($id->id);
        
            $customPage->display_name = $request->page['displayName'];
            $customPage->model        = $request->page['modelName'];
            $customPage->icon         = $request->page['icon'];

            $customPage->save();
            $id = $id->id;
        } else {
            $customPage = new CustomPage;
        
            $customPage->table_name   = $request->page['tableName'];
            $customPage->display_name = $request->page['displayName'];
            $customPage->model        = $request->page['modelName'];
            $customPage->icon         = $request->page['icon'];

            $customPage->save();

            $id = $customPage->id;
        }

        for ($i = 0; $i < count($request->customPageRow); $i++) {
            $customPageRow = new CustomPageRow;

            $customPageRow->custom_page_id = $id;
            $customPageRow->field          = $request->customPageRow[$i]['columnName'];
            $customPageRow->type           = $request->customPageRow[$i]['columnType'];
            $customPageRow->display_name   = $request->customPageRow[$i]['columnDisplayName'];
            $customPageRow->column_browse  = $request->customPageRow[$i]['columnBrowse'];
            $customPageRow->column_read    = $request->customPageRow[$i]['columnRead'];
            $customPageRow->column_edit    = $request->customPageRow[$i]['columnEdit'];
            $customPageRow->column_add     = $request->customPageRow[$i]['columnAdd'];
            $customPageRow->details        = $request->customPageRow[$i]['columnDetails'];
            $customPageRow->position       = $request->customPageRow[$i]['position'];

            $customPageRow->save();
        }

        $key_names = ['browse', 'read', 'edit', 'add', 'delete'];

        foreach ($key_names as $key_name) {
            $permission = new Permission;

            $permission->key        = $key_name . '_' . $request->page['tableName'];
            $permission->key_name   = $key_name;
            $permission->table_name = $request->page['tableName'];

            $permission->save();
        }

        if (file_exists(resource_path('redwineLang/pages'))) {

            $languages = File::directories(resource_path('redwineLang/pages'));

            foreach ($languages as $key => $lang) {
                
                $array = [];
                
                if (substr($request->page['displayName'], 0, 1) == '{' && substr($request->page['displayName'], -1) == '}') {
                    $array[substr($request->page['displayName'], 1, -1)] = substr($request->page['displayName'], 1, -1);
                } else {
                    $array[$request->page['displayName']] = $request->page['displayName'];
                }

                for ($i = 0; $i < count($request->customPageRow); $i++) {
                    $array[$request->customPageRow[$i]['columnName']] = $request->customPageRow[$i]['columnName'];
                }

                $json = json_encode($array, JSON_UNESCAPED_UNICODE);

                File::put(resource_path('redwineLang/pages/' . basename($lang) . '/' . $request->page['tableName'] . '.json'), $json);
            }

        }
        
        return response()->json($array);
    }

    public function viewEdit($table)
    {
        Redwine::permissionFail('edit_custom_page');

        $customPage = CustomPage::where('table_name', $table)->first();

        $customPageRow = CustomPageRow::where('custom_page_id', $customPage->id)->orderBy('position', 'asc')->get();

        $columns = DB::select('describe ' . $table);

        $customPageArray = [];

        foreach ($customPageRow as $key => $column) {
            $customPageArray[$key] = $column->field;
        }

        $columnArray = [];

        foreach ($columns as $key => $column) {
            if (!in_array($column->Field, $customPageArray)) {
                $columnArray[count($columnArray)] =  $column->Field;
            }
        }

        $controller = $this;

        return view('redwine::page.editcustompage', compact('customPage', 'customPageRow', 'table', 'columnArray', 'controller'));
    }

    public function columnDetail($table, $column)
    {
        return DB::select('describe ' . $table . ' ' . $column);
    }

    public function edit(Request $request)
    {
        Redwine::permissionFail('edit_custom_page');

        $id = CustomPage::select('id')->where('table_name', $request->page['tableName'])->first();
        
        $customPage = CustomPage::find($id->id);
        
        $customPage->display_name = $request->page['displayName'];
        $customPage->model = $request->page['modelName'];
        $customPage->icon = $request->page['icon'];

        $customPage->save();

        for ($i = 0; $i < count($request->customPageRow); $i++) {
            if ($request->customPageRow[$i]['id'] != '') {
                $customPageRow = CustomPageRow::find($request->customPageRow[$i]['id']);

                $customPageRow->custom_page_id = $customPage->id;
                $customPageRow->field          = $request->customPageRow[$i]['columnName'];
                $customPageRow->type           = $request->customPageRow[$i]['columnType'];
                $customPageRow->display_name   = $request->customPageRow[$i]['columnDisplayName'];
                $customPageRow->column_browse  = $request->customPageRow[$i]['columnBrowse'];
                $customPageRow->column_read    = $request->customPageRow[$i]['columnRead'];
                $customPageRow->column_edit    = $request->customPageRow[$i]['columnEdit'];
                $customPageRow->column_add     = $request->customPageRow[$i]['columnAdd'];
                $customPageRow->details        = $request->customPageRow[$i]['columnDetails'];
                $customPageRow->position       = $request->customPageRow[$i]['position'];

                $customPageRow->save();
            } else {
                $customPageRow = new CustomPageRow;

                $customPageRow->custom_page_id = $id->id;
                $customPageRow->field          = $request->customPageRow[$i]['columnName'];
                $customPageRow->type           = $request->customPageRow[$i]['columnType'];
                $customPageRow->display_name   = $request->customPageRow[$i]['columnDisplayName'];
                $customPageRow->column_browse  = $request->customPageRow[$i]['columnBrowse'];
                $customPageRow->column_read    = $request->customPageRow[$i]['columnRead'];
                $customPageRow->column_edit    = $request->customPageRow[$i]['columnEdit'];
                $customPageRow->column_add     = $request->customPageRow[$i]['columnAdd'];
                $customPageRow->details        = $request->customPageRow[$i]['columnDetails'];
                $customPageRow->position       = $request->customPageRow[$i]['position'];

                $customPageRow->save();
            }
        }

        return response()->json(true);
    }
}
