<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// For file storage/uploading
use Illuminate\Support\Facades\Storage;
use App\File;

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
        // Upload the file for later retrieval

        // TODO: Put it in the corresponding project folder
        Storage::makeDirectory("project1");

        $files = $request->file('files');

        if(!empty($files)){
            foreach ($files as $file) {
                $filepath = $file->store('project1');

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
                    'folder_id' => 1, // TODO: corresponds to project 1 by default, this needs to be fixed
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