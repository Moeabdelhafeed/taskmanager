<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function user(){
        return $this ->belongsTo('App\Models\User');
    }

    protected $fillable = [
        'name', 'content', 'user_id', 'project_id', 'deadline', 'submitted_at', 'iscomplete'
    ];
    
    
    protected $dates = ['deleted_at' , 'deadline' , 'submited_at'];

    public function images()
{
    return $this->hasMany('App\Models\Image', 'task_id');
}

public function notes(){
    return $this->hasMany(Note::class);
}

}
