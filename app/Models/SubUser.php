<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUser extends Model
{
    use HasFactory;

    protected $fillable = ['main_user_id', 'nickname', 'user_image_path'];

    public function tasks2()
    {
        return $this->belongsToMany(Task::class, 'subuser_tasks')->withPivot('completed')->withTimestamps();
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'subuser_tasks')
            ->using(SubUserTask::class)
            ->withPivot('completed')
            ->withTimestamps();
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'main_user_id');
    }
}
