<?php

namespace App\Repositories;

use App\Models\TodoList;

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

}
