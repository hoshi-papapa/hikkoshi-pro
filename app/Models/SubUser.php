<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
