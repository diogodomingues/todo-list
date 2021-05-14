<?php

namespace App\Services;

use App\Repositories\TodoListRepository;
use App\Services\UserService;

class TodoListService extends Service
{   
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
    public function getAllTodoListsByUser(int $user)
    {
        $result = [];

        $user = $this->userService->getUserById($user);

        if (!empty($user)) {
            $result = $this->repository->getAllTodoListsByUser($user->id);
        }

        return $result;
    }
}
