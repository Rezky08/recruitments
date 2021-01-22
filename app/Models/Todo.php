<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = ['todo_name'];
    public function todolists()
    {
        return $this->hasMany(TodoList::class, 'todo_id', 'id');
    }
    public function labels()
    {
        return $this->belongsToMany(Labels::class, 'todo_label', 'todo_id', 'label_id');
    }
    public function notes()
    {
        return $this->morphMany(Note::class, 'can_note');
    }
}
