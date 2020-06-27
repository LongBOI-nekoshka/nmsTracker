<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';
    public $primaryKey = 'Issue_Id';

    public function project() {
        return $this->belongsTo('App\Project');
    }
}
