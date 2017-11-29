<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taskuser extends Model
{
    //
    protected $fillable=[
        'task_id',
        'user_id',
    ];

 
}
