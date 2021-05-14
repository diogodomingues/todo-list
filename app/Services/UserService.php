<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends Service
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUserById(int $id)
    {
        return $this->repository->getUserById($id);
    }

    public function getUserByEmail(string $email)
    {
        return $this->repository->getUserByEmail($email);
    }
}
