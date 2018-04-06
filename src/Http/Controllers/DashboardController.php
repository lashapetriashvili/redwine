<?php

namespace Redwine\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Redwine\Facades\Redwine;
use Redwine\Models\User;
use File;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = User::count();
        $size  = $this->size('uploads');
        $table = DB::select('SHOW TABLES');
        $table = count($table); 

        return view('redwine::dashboard', compact('user', 'table', 'size'));
    }

    public function size($fileName)
    {
        $fileSize = 0;

        foreach( File::allFiles($fileName) as $file){
            $fileSize += $file->getSize();
        }

        return number_format($fileSize / 1048576,2);
    }
}
