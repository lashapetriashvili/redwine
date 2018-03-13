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

        $user = User::count();

        $table = DB::select('SHOW TABLES');

        $table = count($table);

        return view('redwine::dashboard', compact('user', 'table'));
    }
}
