<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    public $primaryKey = 'Project_Id';

    Public function issues() {
        return $this->hasMany('App\Issue');
    }

    Public function user() {
        return $this->belongsTo('App\User');
    }
}
