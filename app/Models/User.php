<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
    
        ];
    }


    public function role(){
        return $this->belongsTo('App\Models\Role' , 'role_id');

    }

    public function projects(){
        return $this->belongsToMany('App\Models\Project', 'project_user' );
    }

    public function tasks(){
        return $this->hasMany('App\Models\Task');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the users created by this user.
     */
    public function createdusers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function createdprojects(){
        return $this->hasMany(Project::class , 'manager_id');
    }

    protected $dates = ['deleted_at'];
    
}
