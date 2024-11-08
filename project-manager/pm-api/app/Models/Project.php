<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    //RELATIONS

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function image() {
        return $this->morphOne(Image::class,'imageable');
    }
}
