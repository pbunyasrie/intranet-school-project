<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Role;

class UserController extends Controller
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
    public function update(Request $request)
    {
        if(Auth::user()->hasRole("Site Manager")){
            $roles = collect($request->input('role'));
            $users = collect($request->input('user'));

            if($users->count() > 0){
                $users->each(function ($item, $key) use($roles){
                    $user = User::find($item);
                    $role = Role::find($roles[$item]);
                    $user->roles()->sync($role);

                    Log::info(Auth::user()->email . ' updated the user "' . $user->email . '" to ' . $role->name);
                    $user->save();
                });   

                return redirect()->back()->with('status', 'The selected users have been updated');
            }else{
                return redirect()->back()->with('status', 'No users were selected');
            }
        }
        response('Unauthorized', 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if(Auth::user()->hasRole("Site Manager")){
            $users = collect($request->input('user'));

            if($users->count() > 0){
                $users->each(function ($item, $key){

                    $user = User::find($item);

                    Log::info(Auth::user()->email . ' deleted the user "' . $user->email . '"');
                    $user->delete();
                });   

                return redirect()->back()->with('status', 'The selected users have been deleted');
            }else{
                return redirect()->back()->with('status', 'No users were selected');
            }
        }
        response('Unauthorized', 401);
        
    }
}
