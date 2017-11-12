<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// For file storage/uploading
use Illuminate\Support\Facades\Storage;
use App\File;
use App\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
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

    public function upload(Request $request)
    {
        if(!Auth::user()->hasRole("Surveyor")){
            // Upload the file for later retrieval

            // Store the file in the corresponding project folder
            $folder = Folder::find($request->folder);

            Storage::makeDirectory($folder->name);
            $files = $request->file('files');

            if(!empty($files)){
                foreach ($files as $file) {
                    $filepath = $file->store($folder->name);

                    $fullpath = storage_path('app/' . $filepath);


                    #set_include_path('/usr/local/bin/');

                    // Read the contents
                    // $client = \Vaites\ApacheTika\Client::make('/usr/local/Cellar/tika/1.16/libexec/tika-app-1.16.jar');
                    // TODO: Make this asynchronous
                    $client = \Vaites\ApacheTika\Client::make('localhost', 9998, [CURLOPT_TIMEOUT => 600]); // timeout after 10 minutes

                    $text = $client->getText($fullpath);


                    // putenv('PATH=' . getenv('PATH') . PATH_SEPARATOR . '/usr/local/bin/' . PATH_SEPARATOR . '/usr/bin/' . PATH_SEPARATOR . '/bin/' . PATH_SEPARATOR . '/usr/sbin/' );

                    // dd(phpinfo());
                    // dd($text); // show the parsed text from Tika
                    // $metadata = $client->getMetadata($fullpath);

                    // Save the file information into the search engine/database so that it is easily searchable
                    File::create([
                        'folder_id' => $folder->id,
                        'filename' => $file->getClientOriginalName(),
                        'filepath' => $filepath,
                        'contents' => $text
                    ]);
                }

                Log::info(Auth::user()->email . ' uploaded file "' . $file->getClientOriginalName() . '"');

                // Ensure that the upload was successful
                // if ($request->file('file')->isValid()) {
                    
                // }

                if($folder->id == 1){
                    return redirect()->route('folders')->with('status', 'File has been uploaded');    
                }else{
                    return redirect()->route('folder', ['folder' => $folder->id])->with('status', 'File has been uploaded');    
                }
            }
            
        }

        response('Unauthorized', 401);
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
