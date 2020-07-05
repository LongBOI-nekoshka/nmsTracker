<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Issue;

class Comment extends Model
{
    protected $table = 'comments';
    public $primaryKey = 'comment_id';
    //
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function issue() {
        return $this->belongsTo('App\Issue');
    }
}
