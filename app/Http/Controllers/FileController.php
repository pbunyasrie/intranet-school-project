<?php

namespace App\Http\Controllers;
use App\File;
use App\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
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

    public function delete(Request $request)
    {
        if(!Auth::user()->hasRole("Surveyor")){
            $files = collect($request->input('file'));

            if($files->count() > 0){
                $recycleBin = Folder::find(1);
                $files->each(function ($fileID, $key) use($recycleBin){
                    $file = File::find($fileID);
                    $file->folder()->dissociate();
                    $file->folder()->associate($recycleBin);
                    Log::info(Auth::user()->email . ' moved the file "' . $file->filename . '" to the recycle bin');
                    $file->save();
                });   
                return redirect()->back()->with('status', 'The selected files have been moved to the recycle bin');
            }else{
                return redirect()->back()->with('status', 'No files were selected');
            }
        }
        response('Unauthorized', 401);

    }
}
