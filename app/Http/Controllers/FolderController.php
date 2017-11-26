<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\File;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FolderController extends Controller
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
       $folder = Folder::find(1); // this is the recycle bin
       return view('folders', compact('folder'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('folders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasRole("Surveyor")){
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:folders|max:255',
                'description' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->route('folderCreate')
                            ->withErrors($validator)
                            ->withInput();
            }

            $folder = new Folder;
            $folder->name = $request->name;
            $folder->description = $request->description;
            $folder->save();

            Log::info(Auth::user()->email . ' created the folder "' . $folder->name . '"');

            return redirect()->route('folder', ['folder' => $folder->id])->with('status', 'Folder has been created');
        }
        response('Unauthorized', 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {
        if(Auth::user()->isAuthorizedForFolder($folder)){
            return view('folders.folder', compact('folder'));
        }else{
            return redirect()->back()->with('status', 'Sorry, you don\'t have access to that folder');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasRole("Surveyor")){
            $folder = Folder::find($id);
            return view('folders.edit', compact('folder'));
        }
        response('Unauthorized', 401);
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
        if(!Auth::user()->hasRole("Surveyor")){
            $validator = Validator::make($request->all(), [
                'name' => ['required', Rule::unique('folders')->ignore($id)],
                'description' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->route('folderEdit', ['folder' => $id])
                            ->withErrors($validator)
                            ->withInput();
            }

            $folder = Folder::find($id);
            if(empty($folder)){
                abort(500);
            }
            $folder->name = $request->name;
            $folder->description = $request->description;
            $folder->save();
            Log::info(Auth::user()->email . ' updated the folder "' . $folder->name . '"');


            return redirect()->route('folder', ['folder' => $folder->id])->with('status', 'Folder has been updated');
        }
        response('Unauthorized', 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!Auth::user()->hasRole("Surveyor")){
            // Move all files from this folder to the "Files not in a folder" folder
            $files = File::where('folder_id', $request->folder_id)->get();

            foreach ($files as $file) {
                $file->folder_id = 1; // files with no folder goes to ID 1
                $file->save();
            }
            Log::info(Auth::user()->email . ' deleted the folder "' . Folder::find($request->folder_id)->name . '"');
            Folder::destroy($request->folder_id);         
            return redirect()->route('folders')->with('status', 'Folder has been deleted');
        }
        response('Unauthorized', 401);
    }

    public function delete(Request $request)
    {
        if(Auth::user()->hasRole("Site Manager")){
            $folders = collect($request->input('folder'));

            if($folders->count() > 0){
                $folders->each(function ($item, $key){

                    
                    $folder = Folder::find($item);

                    // Move all files from this folder to the "Files not in a folder" folder
                    $files = File::where('folder_id', $folder->id)->get();
                    
                    foreach ($files as $file) {
                        $file->folder()->associate(1); // files with no folder goes to ID 1
                        $file->save();
                    }

                    Log::info(Auth::user()->email . ' deleted the folder "' . $folder->name . '"');
                    $folder->delete();
                });   

                return redirect()->back()->with('status', 'The selected folders have been deleted');
            }else{
                return redirect()->back()->with('status', 'No folders were selected');
            }
        }
        response('Unauthorized', 401);

    }
}
