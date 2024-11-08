<?php

namespace App\Models;

use App\Traits\Jwt;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Jwt;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'image',
        'inicial'
    ];

    public function getImageAttribute() {
        return 'src/assets/img/user.webp2';
    }

    public function getInicialAttribute() {
        return $this->name[0];
    }

    public function projectsCreated() {
        return $this->hasMany(Project::class);
    }

    public function  tasks() {
        return $this->hasMany(Task::class);
    }

    public function projectsWithAssignedTasks() {
        return Project::whereHas('tasks',function ($query) {
            $query->where('user_id',$this->id);
        });
    }
}
