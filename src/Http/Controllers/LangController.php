<?php

namespace Redwine\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Redwine\Facades\Redwine;
use App;

class LangController extends Controller
{
    public function index()
    {
        Redwine::permissionFail('browse_language');

        if (!file_exists(resource_path('redwineLang'))) {
            File::makeDirectory(resource_path('redwineLang'));
        }
        
        $directories = File::directories(resource_path('redwineLang'));
        
        return view('redwine::lang.table', compact('directories'));
    }

    public function addDirectorie($name)
    {
        Redwine::permissionFail('add_language');

        $name = strtolower($name);

        if (!file_exists(resource_path('redwineLang/' . $name))) {
            $add = File::makeDirectory(resource_path('redwineLang/' . $name));
            $add = $add ? File::makeDirectory(resource_path('redwineLang/' . $name . '/' . App::getLocale())) : $add;
        } else {
            $add = false;
        }

        return response()->json(resource_path('redwineLang/' . $name . '/' . App::getLocale()));
    }

    public function editDirectorie($oldName, $newName)
    {
        Redwine::permissionFail('edit_language');

        $newName = strtolower($newName);

        if (!file_exists(resource_path('redwineLang/' . $newName))) {
            $edit = rename(resource_path('redwineLang/' . $oldName), resource_path('redwineLang/' . $newName));
        } else {
            $edit = false;
        }

        return response()->json($edit);
    }

    public function deleteDirectorie($name)
    {
        Redwine::permissionFail('delete_language');

        $delete = File::deleteDirectory(resource_path('redwineLang/' . $name));

        return response()->json($delete);
    }

    public function readLanguage($directorie)
    {
        Redwine::permissionFail('read_language');

        $languages = File::directories(resource_path('redwineLang/' . $directorie));

        return view('redwine::lang.language', compact('languages', 'directorie'));
    }

    public function addLanguage($directorie, $name)
    {
        Redwine::permissionFail('add_language');

        $name = strtolower($name);

        if (!file_exists(resource_path('redwineLang/' . $directorie . '/' . $name))) {
            if (file_exists(resource_path('redwineLang/' . $directorie . '/' . App::getLocale()))) {
                $add = File::copyDirectory(resource_path('redwineLang/' . $directorie . '/' . App::getLocale()), resource_path('redwineLang/' . $directorie . '/' . $name));
            } else {
               $add = File::makeDirectory(resource_path('redwineLang/' . $directorie . '/' . $name)); 
           }
        } else {
            $add = false;
        }

        return response()->json($add);
    }

    public function editLanguage($directorie, $oldName, $newName)
    {
        Redwine::permissionFail('edit_language');

        $newName = strtolower($newName);

        if (!file_exists(resource_path('redwineLang/' . $directorie . '/' . $newName))) {
            $edit = rename(resource_path('redwineLang/' . $directorie . '/' . $oldName), resource_path('redwineLang/' . $directorie . '/' . $newName));
        } else {
            $edit = false;
        }

        return response()->json($edit);
    }

    public function deleteLanguage($directorie, $name)
    {
        Redwine::permissionFail('delete_language');

        $delete = File::deleteDirectory(resource_path('redwineLang/' . $directorie . '/' . $name));

        return response()->json($delete);
    }

    public function readFileLanguage($directorie, $language)
    {
        Redwine::permissionFail('read_language');

        $files = File::files(resource_path('redwineLang/' . $directorie . '/' . $language));
        
        return view('redwine::lang.fileTable', compact('files', 'directorie', 'language'));
    }

    public function addFileLanguage($directorie, $language, $name)
    {
        Redwine::permissionFail('add_language');

        $name = strtolower($name);

        if (!file_exists(resource_path('redwineLang/' . $directorie . '/' . $language . '/' . $name . '.json'))) {
            $add = File::put(resource_path('redwineLang/' . $directorie . '/' . $language . '/' . $name . '.json'), '');
        } else {
            $add = false;
        }

        return response()->json($add);
    }

    public function editFileLanguage($directorie, $language, $oldName, $newName)
    {
        Redwine::permissionFail('edit_language');

        $newName = strtolower($newName);

        if (!file_exists(resource_path('redwineLang/' . $directorie . '/' . $language . '/' . $newName . '.json'))) {
            $edit = rename(resource_path('redwineLang/' . $directorie . '/' . $language . '/' . $oldName . '.json'), resource_path('redwineLang/' . $directorie . '/' . $language . '/' . $newName . '.json'));
        } else {
            $edit = false;
        }

        return response()->json($edit);
    }

    public function deleteFileLanguage($directorie, $language, $name)
    {
        Redwine::permissionFail('delete_language');

        $delete = File::delete(resource_path('redwineLang/' . $directorie . '/' . $language . '/' . $name . '.json'));

        return response()->json($delete);
    }

    public function readWordLanguage($directorie, $language, $file)
    {
        Redwine::permissionFail('read_language');

        $json = File::get(resource_path('redwineLang/' . $directorie . '/' . $language . '/' . $file . '.json'));

        $words = $json != '' ? json_decode($json, true) : [];

        return view('redwine::lang.word', compact('words', 'file', 'directorie', 'language'));
    }

    public function addWordLanguage(Request $request)
    {
        Redwine::permissionFail('add_language');

        $json = File::get(resource_path('redwineLang/' . $request->directorie . '/' . $request->language . '/' . $request->file . '.json'));

        $words = $json != '' ? json_decode($json, true) : [];

        $name = strtolower($request->name);

        $words[$name] = $request->lang;

        $json = json_encode($words, JSON_UNESCAPED_UNICODE);

        $save = File::put(resource_path('redwineLang/' . $request->directorie . '/' . $request->language . '/' . $request->file . '.json'), $json);

        return response()->json($save);
    }

    public function editWordLanguage(Request $request)
    {
        Redwine::permissionFail('edit_language');

        $json = File::get(resource_path('redwineLang/' . $request->directorie . '/' . $request->language . '/' . $request->file . '.json'));

        $words = $json != '' ? json_decode($json, true) : [];

        $words[$request->oldLang] = $request->name;

        $json = json_encode($words, JSON_UNESCAPED_UNICODE);

        $save = File::put(resource_path('redwineLang/' . $request->directorie . '/' . $request->language . '/' . $request->file . '.json'), $json);

        return response()->json($save);
    }

    public function deleteWordLanguage(Request $request)
    {
        Redwine::permissionFail('delete_language');

        $json = File::get(resource_path('redwineLang/' . $request->directorie . '/' . $request->language . '/' . $request->file . '.json'));

        $words = $json != '' ? json_decode($json, true) : [];
        unset($words[$request->lang]);

        $json = json_encode($words, JSON_UNESCAPED_UNICODE);

        $save = File::put(resource_path('redwineLang/' . $request->directorie . '/' . $request->language . '/' . $request->file . '.json'), $json);

        return response()->json($save);
    }
}
