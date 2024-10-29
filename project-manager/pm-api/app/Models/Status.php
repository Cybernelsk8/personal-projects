<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'name',
        'deleted_at'
    ];

    public $timestamps = false;


    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
