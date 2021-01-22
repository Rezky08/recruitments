<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Class_;

class TodoList extends Model
{
    use HasFactory;
    protected $table = "lists";
    protected $fillable = ['list_name', 'todo_id'];
    public function todo()
    {
        return $this->belongsTo(Todo::class, 'todo_id', 'id');
    }
    public function notes()
    {
        return $this->morphMany(Note::class, 'can_note');
    }
}
