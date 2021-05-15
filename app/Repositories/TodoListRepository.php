<?php

namespace App\Repositories;

use App\Models\TodoList;
use Carbon\Carbon;

class TodoListRepository extends Repository
{
    public function __construct(TodoList $brand)
    {
        $this->model = $brand;
    }

    /**
     * Return all to-do Lists available
     * 
     * @return Collection
     */
    public function getAllTodoLists(): \Illuminate\Support\Collection
    {
        return TodoList::get();
    }

    /**
     * Return all to-do Lists for a given user
     * 
     * @param string $userId
     * 
     * @return Collection
     */
    public function getAllTodoListsByUser(string $userId): \Illuminate\Support\Collection
    {
        return TodoList::where('user_id', '=', $userId)
            ->get();
    }

    /**
     * create new to-do Lists 
     * 
     * @param array $data
     * 
     * @return TodoList
     */
    public function createTodoList(array $data): TodoList
    {
        return TodoList::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'user_id' => $data['userId'],
            'created_at' => Carbon::now()->toDateTimeString(),
            'deleted_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    /**
     * delete to-do List by id
     * 
     * @param int $todoId
     * 
     * @return bool
     */
    public function deleteTodoList(int $todoId): bool
    {
        return TodoList::where('id', '=', $todoId)
            ->delete();
    }

}
