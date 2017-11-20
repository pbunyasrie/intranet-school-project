<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
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

    public function usersShow()
    {
        if(Auth::user()->hasRole("Site Manager")){
            // $request->user()->authorizeRoles(['user']);
            // $files = Storage::allFiles('project1');
            $users = User::all();

            return view('admin.users', compact('users'));
        }
        response('Unauthorized', 401);
    }

    public function foldersShow()
    {
        if(Auth::user()->hasRole("Site Manager")){
            return view('admin.folders');
        }
        response('Unauthorized', 401);
    }

    public function usersAccessShow($user)
    {
        if(Auth::user()->hasRole("Site Manager")){
            $user = User::find($user);
            return view('admin.usersAccess', compact('user'));
        }
        response('Unauthorized', 401);
    }

    public function foldersAccessShow($folder)
    {
        if(Auth::user()->hasRole("Site Manager")){
            $folder = Folder::find($folder);
            return view('admin.foldersAccess', compact('folder'));
        }
        response('Unauthorized', 401);
    }

    public function sendMessage()
    {
        if(Auth::user()->hasRole("Site Manager")){
            return view('admin.sendMessage');
        }
        response('Unauthorized', 401);
    }


}
