<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Template\Template;

class Task extends Model
{
    use HasFactory;

    public function subusers()
    {
        return $this->belongsToMany(SubUser::class)->withTimestamps();
    }

    public function templatetasks()
    {
        return $this->belongsTo(Template::class);
    }
}
