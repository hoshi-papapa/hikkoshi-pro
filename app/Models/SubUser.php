<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    use HasFactory;

    protected $fillable = ['main_user_id', 'nickname', 'user_image_path'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'subuser_tasks')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
