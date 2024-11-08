<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'user_id',
        'task_id',
        'status_id',
        'deleted_at'
    ];


    //RELATIONS INVERSE
    public function project() {
        return $this->belongsTo(project::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
