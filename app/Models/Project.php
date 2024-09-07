<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function users(){
        return $this->belongsToMany('App\Models\User', 'project_user' );
    }

    public function tasks(){
        return $this->hasMany('App\Models\Task');
    }

    public function manager(){
        return $this->belongsTo(User::class , 'manager_id');
    }

    protected $dates = ['deleted_at'];
}
