<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'todo_list_id',
        'status_id',
        'created_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * Relationship with TasksStatuses
     */
    public function status()
    {
        return $this->hasOne('App\Models\TasksStatuses', 'id', 'status_id');
    }

    /**
     * Relationship with TodoList
     */
    public function todoList()
    {
        return $this->belongsTo('App\Models\TodoList', 'todo_list_id', 'id');
    }

}
