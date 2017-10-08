<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;

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
        $request->user()->authorizeRoles(['user']);
        return view('home');
    }

    public function search(Request $request){
        $query = "";
        if($request->has('search')){
          $files = File::search($request->input('search'))->get();
          $query = $request->input('search');
        }
       return view('home', compact('files', 'query'));
    }
}
