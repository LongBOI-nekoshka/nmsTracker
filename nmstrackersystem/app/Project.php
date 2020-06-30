<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    public $primaryKey = 'Project_Id';

    public function issues() {
        return $this->hasMany('App\Issue');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
