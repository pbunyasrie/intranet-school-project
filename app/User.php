<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getUsersByRole($role){
      return User::all()->map(function($user) use ($role) { 
        if($user->hasRole($role)){
          return $user;
        }
      })->filter();
    }

    public function roles()
    {
      return $this
        ->belongsToMany('App\Role')
        ->withTimestamps();
    }

    public function authorizeRoles($roles)
    {
      if ($this->hasAnyRole($roles)) {
        return true;
      }
      abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles)
    {
      if (is_array($roles)) {
        foreach ($roles as $role) {
          if ($this->hasRole($role)) {
            return true;
          }
        }
      } else {
        if ($this->hasRole($roles)) {
          return true;
        }
      }
      return false;
    }
    
    public function hasRole($role)
    {
      if ($this->roles()->where('name', $role)->first()) {
        return true;
      }
      return false;
    }

    public function foldersAccess(){
        return $this->manyThroughMany('App\Folder', 'App\FolderAccessUser', 'user_id', 'id', 'folder_id');
    }

    public function foldersWithAccess()
    {
        if($this->hasRole("Site Manager")){
          return Folder::all();
        }else{
          $folders = $this->foldersAccess()->get();
          return $folders;
        }
    }

    public function foldersWithNoAccess()
    {
        if(!$this->hasRole("Site Manager")){
          return Folder::all()->whereNotIn('id', $this->foldersWithAccess()->pluck('id')->toArray());
        }else{
          return;
        }
    }


    public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    {
        $model = new $related;
        $table = $model->getTable();
        $throughModel = new $through;
        $pivot = $throughModel->getTable();

        return $model
            ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
            ->select($table . '.*')
            ->where($pivot . '.' . $firstKey, '=', $this->id);
    }
}
