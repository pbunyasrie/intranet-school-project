<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\File;
use App\Folder;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $request->user()->authorizeRoles(['user']);
        // $files = Storage::allFiles('project1');
        $files = File::all();
        $folder = Folder::find(1);

        return view('home', compact('files', 'folder'));
    }

    public function settings()
    {
        return view('account.settings');
    }

    public function help()
    {
        return view('help');
    }


}
