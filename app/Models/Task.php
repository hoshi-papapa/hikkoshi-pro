<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Template\Template;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_user_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'completed',
        'is_template_task',
        'template_task_id'
    ];

    public function subUsers()
    {
        return $this->belongsToMany(SubUser::class, 'subuser_tasks')
            ->using(SubUserTask::class)
            ->withPivot('completed')
            ->withTimestamps();
    }
    public function templatetasks()
    {
        return $this->belongsTo(Template::class);
    }
}
