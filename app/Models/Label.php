<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;
    public function todos()
    {
        return $this->belongsToMany(Todo::class, 'todo_label', 'label_id', 'todo_id');
    }
}
