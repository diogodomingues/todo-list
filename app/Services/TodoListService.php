<?php

namespace App\Services;

use App\Repositories\TodoListRepository;
use App\Services\UserService;

class TodoListService extends Service
{   
    const USER_NOT_FOUND = 'User not found';
    
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(TodoListRepository $repository, UserService $userService)
    {
        $this->repository = $repository;
        $this->userService = $userService;
    }

    /**
     *  get all to-do lists
     */
    public function getAllTodoLists()
    {
        return $this->repository->getAllTodoLists();
    }

    /**
     * get all to-do lists for a given user
     */
    public function getAllTodoListsByUser(int $userId)
    {
        $user = $this->userService->getUserById($userId);

        if (!empty($user)) {
           return $this->repository->getAllTodoListsByUser($user->id);
        }

        return self::USER_NOT_FOUND;
    }

    /**
     * create new to-do list
     */
    public function createTodoList(array $data)
    {
        $user = $this->userService->getUserById($data['userId']);

        if (!empty($user)) {
            return  $this->repository->createTodoList($data);
        }

        return self::USER_NOT_FOUND;
    }

    /**
     * delete to-do list
     */
    public function deleteTodoList(int $todoId)
    {
        return $this->repository->deleteTodoList($todoId);
    }

    
}
