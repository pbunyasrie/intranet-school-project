<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
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

    public function search(Request $request){
        $query = $request->input('query');
        $type = $request->input('type');
        
        if(empty($query)){
            $query = "";
        }
        
        if($type){
            $files = File::search($query)->where('extension', $type)->get();  
        }else{
            $files = File::search($query)->get();  
        }

        // Make sure the user is authorized for any files found
        $files = $files->filter(function ($file, $key){
            if(Auth::user()->isAuthorizedForFolder($file->folder()->first())){
                return $file;
            }
        });

        // Make sure the user is authorized for any folders found
        $folders = Folder::search($query)->get()->filter(function ($folder, $key){
            if(Auth::user()->isAuthorizedForFolder($folder)){
                return $folder;
            }
        });

        Log::info(Auth::user()->email . ' searched for "' . $query . '"');

        return view('searchresults', compact('files', 'folders', 'query', 'type'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
