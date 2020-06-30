<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $primaryKey = 'Role_Id';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
