<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\File;
use App\Folder;
use App\FolderAccessUser;
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
            $folderAccess = FolderAccessUser::all()->where('user_id', $user->id);
            return view('admin.usersAccess', compact('user', 'folderAccess'));
        }
        response('Unauthorized', 401);
    }

    public function foldersAccessShow($folder)
    {
        if(Auth::user()->hasRole("Site Manager")){
            $folder = Folder::find($folder);
            $folderAccess = FolderAccessUser::all()->where('folder_id', $folder->id);
            return view('admin.foldersAccess', compact('folder', 'folderAccess'));
        }
        response('Unauthorized', 401);
    }

    public function grantFolderAccess(Request $request, $folder){
        if(Auth::user()->hasRole("Site Manager")){
            $folder = Folder::find($folder);

            // Grant access to users
            if($request->has('noAccessUser')){
                $users = collect($request->input('noAccessUser'));
                $status = "Access granted to the users";

                if($users->count() > 0){
                    $users->each(function ($item, $key) use ($folder){
                        $user = User::find($item);
                        FolderAccessUser::firstOrCreate([
                            'folder_id' => $folder->id,
                            'user_id' => $user->id
                        ]);
                    });
                }else{
                    return redirect()->back()->with('status', 'No users were selected');
                }
            }
            
            return redirect()->back()->with('status', $status);
        }
        response('Unauthorized', 401);
    }

    public function revokeFolderAccess(Request $request, $folder){
        if(Auth::user()->hasRole("Site Manager")){
            $folder = Folder::find($folder);
            $status = "";

            // Revoke access from users
            if($request->has('AccessUser')){
                $users = collect($request->input('AccessUser'));
                $status = "Access revoked from users";

                if($users->count() > 0){
                    $users->each(function ($item, $key) use ($folder){
                        $user = User::find($item);
                        FolderAccessUser::where('folder_id', $folder->id)
                                            ->where('user_id', $user->id)
                                            ->delete();

                    });
                }else{
                    return redirect()->back()->with('status', 'No users were selected');
                }
            }
            
            return redirect()->back()->with('status', $status);
        }
        response('Unauthorized', 401);
    }

    public function grantUserAccess(Request $request, $user){
        if(Auth::user()->hasRole("Site Manager")){
            $user = User::find($user);

            if($request->has('noAccessFolder')){
                $folders = collect($request->input('noAccessFolder'));
                $status = "Access granted to the selected folders";

                if($folders->count() > 0){
                    $folders->each(function ($item, $key) use ($user){
                        $folder = Folder::find($item);
                        FolderAccessUser::firstOrCreate([
                            'folder_id' => $folder->id,
                            'user_id' => $user->id
                        ]);
                    });
                }else{
                    return redirect()->back()->with('status', 'No folders were selected');
                }
            }
            
            return redirect()->back()->with('status', $status);
        }
        response('Unauthorized', 401);
    }

    public function revokeUserAccess(Request $request, $user){
        if(Auth::user()->hasRole("Site Manager")){
            $user = User::find($user);
            $status = "";

            if($request->has('AccessFolder')){
                $folders = collect($request->input('AccessFolder'));
                $status = "Access revoked from the selected folders";

                if($folders->count() > 0){
                    $folders->each(function ($item, $key) use ($user){
                        $folder = Folder::find($item);
                        FolderAccessUser::where('folder_id', $folder->id)
                                            ->where('user_id', $user->id)
                                            ->delete();

                    });
                }else{
                    return redirect()->back()->with('status', 'No folders were selected');
                }
            }
            
            return redirect()->back()->with('status', $status);
        }
        response('Unauthorized', 401);
    }

    public function recycle(Request $request)
    {
        if(Auth::user()->hasRole("Site Manager")){
            $files = collect($request->input('file'));

            if($files->count() > 0){
                $files->each(function ($item, $key){
                    $file = File::find($item);
                    Log::info(Auth::user()->email . ' deleted the file "' . $file->filename . '"');
                    //TODO: Delete the file on the disk too (based on the $file->filepath)
                    $file->delete();
                });   

                return redirect()->back()->with('status', 'The selected files have been deleted');
            }else{
                return redirect()->back()->with('status', 'No files were selected');
            }
        }
        response('Unauthorized', 401);

    }

    public function recycleShow()
    {

        if(Auth::user()->hasRole("Site Manager")){ 
            $folder = Folder::find(1); // this is the recycle bin
            return view('recycle', compact('folder'));
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
