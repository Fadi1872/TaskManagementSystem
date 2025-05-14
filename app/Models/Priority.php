<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = ['name', 'level'];

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
