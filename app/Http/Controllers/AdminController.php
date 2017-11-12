<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
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

    public function configurationShow()
    {
        if(Auth::user()->hasRole("Site Manager")){
            return view('admin.configuration');
        }
        response('Unauthorized', 401);
    }


}
