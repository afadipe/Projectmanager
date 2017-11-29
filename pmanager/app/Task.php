<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable=[
        'name',
        'project_id',
        'user_id',
        'days',
        'hours',
        'company_id',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function project(){
        return $this->belongsTo('App\project');
    }

    public function company(){
        return $this->belongsTo('App\company');
    }

    public function Users(){
        return $this->belongsToMany('App\User');
    }


    public function comments(){
        return $this->morphMany('App\Comment','commentable');
    }

}
