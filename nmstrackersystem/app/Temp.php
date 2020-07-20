<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $table = 'temps';
    public $primaryKey = 'temp_id';
}
