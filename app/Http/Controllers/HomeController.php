<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Illuminate\Http\Response;

// For file storage/uploading
use Illuminate\Support\Facades\Storage;

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

        // $files = Storage::allFiles('project1');
        $files = File::all();

        return view('home', compact('files'));
    }

    public function search(Request $request){
        $query = "";
        if($request->has('search')){
          $files = File::search($request->input('search'))->get();
          $query = $request->input('search');
        }
       return view('home', compact('files', 'query'));
    }

    public function upload(Request $request)
    {
        // Upload the file for later retrieval

        // TODO: Put it in the corresponding project folder
        Storage::makeDirectory("project1");

        $files = $request->file('files');

        if(!empty($files)){
            foreach ($files as $file) {
                $filepath = $file->store('project1');

                $fullpath = storage_path('app/' . $filepath);

                // Read the contents
                $client = \Vaites\ApacheTika\Client::make('/usr/local/Cellar/tika/1.16/libexec/tika-app-1.16.jar');

                $text = $client->getText($fullpath);
                // $metadata = $client->getMetadata($fullpath);

                // Save the file information into the search engine/database so that it is easily searchable
                File::create([
                    'project_id' => 1, // TODO: corresponds to project 1 by default, this needs to be fixed
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $filepath,
                    'contents' => $text
                ]);
            }
        }

        // Ensure that the upload was successful
        // if ($request->file('file')->isValid()) {
            
        // }

        return redirect()->route('home');
    }

    public function download($filename)
    {
        $file = File::where('filename', '=', $filename)->firstOrFail();
        $filepath = storage_path('app/' . $file->filepath);
        if (File::exists($filepath)){
            // $fileContents = Storage::disk('local')->get($file->filepath); // grabs the contents of the file
            return response()->download($filepath, $filename);
        }else{
            abort(404);
        }


    }
}
