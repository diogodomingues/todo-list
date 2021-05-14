<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Return all Users
     * 
     * @return Collection
     */
    public function getAllUsers(): \Illuminate\Support\Collection
    {
        return User::get();
    }

    /**
     * Find and return the user by id
     * 
     * @param int $userId
     * 
     * @return mixed
     */
    public function getUserById(int $userId)
    {
        return User::where('id', '=', $userId)
            ->first();
    }

    /**
     * Find and return the user by email
     * 
     * @param int $userId
     * 
     * @return mixed
     */
    public function getUserByEmail(string $email)
    {
        return User::where('email', '=', $email)
            ->first();
    }
}
