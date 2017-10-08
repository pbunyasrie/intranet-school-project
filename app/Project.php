<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function files()
    {
        return $this->hasMany('App\File');
    }
}
