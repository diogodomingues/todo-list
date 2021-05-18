<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\TasksStatus;
use Carbon\Carbon;

class TaskRepository extends Repository
{
    /**
     * Constructor
     */
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * Return all tasks available
     * 
     * @return Collection
     */
    public function getAllTasks(): \Illuminate\Support\Collection
    {
        return Task::get();
    }

    /**
     * Return all tasks for a given to-do list
     * 
     * @param string $userId
     * 
     * @return Collection
     */
    public function getAllTasksByTodoList(int $userId): \Illuminate\Support\Collection
    {
        return Task::whereHas('todoList', function ($query) use ($userId) {
            $query->where('id', '=', $userId);
        })->with('status', 'todoList')->get();
    }

    /**
     * Return a task by it's ID
     * 
     * @param int $taskId
     * 
     * @return Task
     */
    public function getTasksById(int $taskId): Task
    {
        return Task::where('id', '=', $taskId)
            ->with('status', 'todoList')
            ->first();
    }

    /**
     * Create new task
     * 
     * @param array $data
     * 
     * @return Task
     */
    public function createTask(array $data): Task
    {
        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'todo_list_id' => $data['todoListId'],
            'status_id' => $data['statusId']
        ]);
    }

    /**
     * Update task
     * 
     * @param array $data
     * @param Task $task
     * 
     * @return bool
     */
    public function updateTask(array $data, Task $task): bool
    {
        return $task->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'todo_list_id' => $data['todoListId'],
            'status_id' =>  $data['statusId'],
            'update_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    /**
     * delete task by id
     * 
     * @param int $todoId
     * 
     * @return bool
     */
    public function deleteTask(int $taskId): bool
    {
        return Task::where('id', '=', $taskId)
            ->delete();
    }

    /**
     * delete tasks by to-do list ID
     * 
     * @param int $todoId
     * 
     * @return bool
     */
    public function deleteTaskByTodoListId(int $todoId)
    {
        return Task::where('todo_list_id', '=', $todoId)
            ->delete();
    }
}
