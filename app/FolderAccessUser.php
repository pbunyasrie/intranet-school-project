<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FolderAccessUser extends Model
{
	protected $fillable = ['folder_id', 'user_id'];

    public function users(){
	  return $this->belongsToMany('App\User')->withTimestamps();
	}

    public function folder(){
        return $this->has('App\Folder');
    }
}
