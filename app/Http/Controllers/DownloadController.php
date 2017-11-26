<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DownloadController extends Controller
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

    public function download($filename)
    {
        $file = File::where('filename', '=', $filename)->firstOrFail();
        $filepath = storage_path('app/' . $file->filepath);
        if (File::exists($filepath)){
            // $fileContents = Storage::disk('local')->get($file->filepath); // grabs the contents of the file

            if(Auth::user()->isAuthorizedForFolder($file->folder)){
                Log::info(Auth::user()->email . ' downloaded "'. $filename . '"" from the folder "' . $file->folder()->first()->name . '"');
                return response()->download($filepath, $filename);
            }else{
                Log::info(Auth::user()->email . ' tried to download "'. $filename . '" from the folder "' . $file->folder()->first()->name . '", but was not authorized to do so');
                return redirect()->back()->with('status', 'Sorry, you don\'t have access to that file');
            }
            
        }else{
            abort(404);
        }


    }
}
