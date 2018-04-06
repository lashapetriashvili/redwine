<?php

namespace Redwine\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redwine\Facades\Redwine;
use Redwine\Models\CustomPage;
use Redwine\Models\CustomPageRow;
use Redwine\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use File;

class PageController extends Controller
{
    public function index($slug)
    {
        Redwine::permissionFail('browse_' . $slug);

        $customPage = CustomPage::where('table_name', $slug)->first();
        $customPageRow = CustomPageRow::where('custom_page_id', $customPage->id)->orderBy('position', 'asc')->get();

        $model = new $customPage->model;
        $posts = $model->orderBy('id', 'desc')->paginate(10);

        return view('redwine::page.table', [
            'customPage'    => $customPage,
            'customPageRow' => $customPageRow,
            'slug'          => $slug,
            'posts'         => $posts,
            'controller'    => $this
        ]);
    }

    public function read($table, $id)
    {
        Redwine::permissionFail('read_' . $table);

        $customPage = CustomPage::where('table_name', $table)->first();
        $customPageRow = CustomPageRow::select('display_name', 'column_read', 'field', 'type', 'details')
            ->orderBy('position', 'asc')
            ->where('custom_page_id', $customPage->id)
            ->get();

        $model = new $customPage->model;
        $post = $model->where('id', $id)->first();

        $get = [
            'post'    => $post,
            'pageRow' => $customPageRow
        ];

        return response()->json($get);
    }

    public function delete($table, $id)
    {
        Redwine::permissionFail('delete_' . $table);

        $customPage = CustomPage::where('table_name', $table)->first();

        $model = new $customPage->model;
        $delete = $model->where('id', $id)->delete();

        return response()->json($delete);
    }

    public function viewAdd($slug)
    {
        Redwine::permissionFail('browse_' . $slug);

        $customPage = CustomPage::where('table_name', $slug)->first();
        $customPageRows = CustomPageRow::where('custom_page_id', $customPage->id)->where('column_add', 1)->orderBy('position', 'asc')->get();

        return view('redwine::page.add', [
            'customPage'     => $customPage,
            'customPageRows' => $customPageRows,
            'slug'           => $slug,
            'controller'     => $this
        ]);
    }

    public function add($slug, Request $request)
    {
        Redwine::permissionFail('add_' . $slug);

        $customPage = CustomPage::where('table_name', $slug)->first();
        $customPageRows = CustomPageRow::where('custom_page_id', $customPage->id)->where('column_add', 1)->orderBy('position', 'asc')->get();

        $model = new $customPage->model;

        foreach ($customPageRows as $key => $customPageRow) {
            $model[$customPageRow->field] = $request[$customPageRow->field];

            if ($customPageRow->type == 'image') {
                $model[$customPageRow->field] = Redwine::imageUpload($request, $customPageRow->field);
            }

            if ($customPageRow->type == 'checkbox') {
                if ($request[$customPageRow->field] == 'on') {
                    $model[$customPageRow->field] = 1;
                } else {
                    $model[$customPageRow->field] = 0;
                }
            }

            if ($customPageRow->type == 'password') {
                $model[$customPageRow->field] = Hash::make($request[$customPageRow->field]);
            }
        }

        $save = $model->save();

        if ($save) {
            return redirect('redwine/page/' . $slug);
        }
    }

    public function viewEdit($slug, $id)
    {
        Redwine::permissionFail('edit_' . $slug);

        $customPage = CustomPage::where('table_name', $slug)->first();
        $customPageRows = CustomPageRow::where('custom_page_id', $customPage->id)->where('column_edit', 1)->orderBy('position', 'asc')->get();

        $model = new $customPage->model;

        $news = $model->where('id', $id)->get();

        return view('redwine::page.edit', [
            'customPage'     => $customPage,
            'customPageRows' => $customPageRows,
            'slug'           => $slug,
            'controller'     => $this,
            'news'           => $news,
            'id'             => $id
        ]);
    }

    public function edit($slug, $id, Request $request)
    {
        Redwine::permissionFail('edit_' . $slug);

        $customPage = CustomPage::where('table_name', $slug)->first();
        $customPageRows = CustomPageRow::where('custom_page_id', $customPage->id)->where('column_add', 1)->orderBy('position', 'asc')->get();

        $model = $customPage->model;

        $model = $model::find($id);

        foreach ($customPageRows as $key => $customPageRow) {
            $model[$customPageRow->field] = $request[$customPageRow->field];

            if ($customPageRow->type == 'image') {
                if ($request['edit_image_' . $key] != '') {
                    $model[$customPageRow->field] = $request['edit_image_' . $key];
                } else {
                    $model[$customPageRow->field] = Redwine::imageUpload($request, $customPageRow->field);
                }
            }

            if ($customPageRow->type == 'checkbox') {
                if ($request[$customPageRow->field] == 'on') {
                    $model[$customPageRow->field] = 1;
                } else {
                    $model[$customPageRow->field] = 0;
                }
            }

            if ($customPageRow->type == 'password') {
                if ($request[$customPageRow->field] != '') {
                    $model[$customPageRow->field] = Hash::make($request[$customPageRow->field]);
                } else {
                    $get = $model->where('id', $id)->select($customPageRow->field)->first();
                    $model[$customPageRow->field] = $get[$customPageRow->field];
                }
            }
        }

        $save = $model->save();

        if ($save) {
            return redirect('redwine/page/' . $slug);
        }
    }

    public function get($details)
    {
        if (isset(json_decode($details, true)['value'])) {
            if (is_array(json_decode($details, true)['value'])) {
                if (isset(json_decode($details, true)['value']['model'])) {
                    $modelName = json_decode($details, true)['value']['model'];
                    $model = new $modelName;

                    if (isset(json_decode($details, true)['value']['where'])) {
                        $where = json_decode($details, true)['value']['where'];
                    
                        foreach ($where as $key => $value) {
                            if ($value == 'get_user_id') {
                                $model = $model->where($key, Auth::id());
                            } else {
                                $model = $model->where($key, $value);
                            }
                        }
                    }

                    if (isset(json_decode($details, true)['value']['select'])) {
                        
                        $select = json_decode($details, true)['value']['select'];
                        $model  = $model->select($select);
                        $get    = $model->first();

                        return $get ? $get->$select : '';
                    } else {
                        $get = $model->get();

                        if (isset(json_decode($details, true)['value']['value'])) {
                            $array = [$get, json_decode($details, true)['value']['option'], json_decode($details, true)['value']['value']];
                        } else {
                            $array = [$get, json_decode($details, true)['value']['option'], json_decode($details, true)['value']['option']];
                        }

                        return $get ? $array : [];
                    }
                }
            } else {
                $value = json_decode($details, true)['value'];
                return $value == 'get_user_id' ? Auth::id() : $value;
            }
        }
    }

    public function view($details, $value)
    {
        if (isset($details['value']) && $details['value'] == 'get_user_id') {
            $get = User::where('id', $value)->first();
            return $get[$details['display']];
        } else {
            $modelName = $details['display']['model'];
            $model = new $modelName;

            $get = $model->where($details['display']['where'], $value)->first();

            return $get[$details['display']['view']];
        }
    }

    public function viewJson(Request $request)
    {
        $details = $request->details;
        $value = $request->value;

        if (isset($details['value']) && $details['value'] == 'get_user_id') {
            $get = User::where('id', $value)->first();
            return response()->json($get[$details['display']]);
        } else {
            $modelName = $details['display']['model'];
            $model = new $modelName;

            $get = $model->where($details['display']['where'], $value)->first();

            return response()->json($get[$details['display']['view']]);
        }
    }

    public function slug($page, Request $request)
    {
        $customPage = CustomPage::where('table_name', $page)->select('model')->first();

        $model = new $customPage->model;

        $count = $model->where($request->slugColumn, $request->slug)->count();

        return $count == 0 ? response()->json(true) : response()->json(false);
    }

    public function unique($page, Request $request)
    {
        $customPage = CustomPage::where('table_name', $page)->select('model')->first();

        $model = new $customPage->model;

        if (isset($request->id)) {
            $get = $model->where('id', $request->id)->select($request->field)->first();

            $get = $get[$request->field];

            if ($get != $request->value) {
                $count = $model->where($request->field, $request->value)->count();
                return $count > 0 ? response()->json(true) : response()->json(false);
            } else {
                return response()->json(false);
            }
        } else {
            $count = $model->where($request->field, $request->value)->count();
            return $count > 0 ? response()->json(true) : response()->json(false);
        }
    }

    public function language($name)
    {
        if (file_exists(resource_path('redwineLang/' . $name))) {
            return File::directories(resource_path('redwineLang/' . $name));
        } else {
            return [];
        }
    }

    public function lang($text, $file, $uppercase = false)
    {
        if (substr($text, 0, 1) == '{' && substr($text, -1) == '}') {
            $text = Redwine::lang('pages.' . $file . '.' . substr($text, 1, -1), [], Auth::user()->lang);
            return $uppercase ? strtoupper($text) : $text;
        } else {
            return $uppercase ? strtoupper($text) : $text;
        }
    }

    public function ajaxLang($slug, $lang)
    {
        $lang = Redwine::lang('pages.' . $slug . '.' . $lang, [], Auth::user()->lang);

        return response()->json($lang);
    }
}
