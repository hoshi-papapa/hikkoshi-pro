<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SubUserTask extends Pivot
{
    protected $table = 'subuser_tasks';

    public function toggleCompletion()
    {
        $this->completed = !$this->completed;
        $this->save();
    }
}
