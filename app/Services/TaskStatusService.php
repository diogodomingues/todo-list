<?php

namespace App\Services;

use App\Repositories\TaskStatusRepository;

class TaskStatusService extends Service
{
    /**
     * Constructor
     */
    public function __construct(TaskStatusRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *  get all tasksStatus
     */
    public function getAllTasksStatus()
    {
        return $this->repository->getAllTasksStatus();
    }

    /**
     * get taskStatus by Id
     */
    public function getTasksStatusById(int $taskStatusId)
    {
        return $this->repository->getTasksStatusById($taskStatusId);
    }

    /**
     * get taskStatus by code
     */
    public function getTasksStatusByCode(string $code)
    {
        return $this->repository->getTasksStatusByCode($code);
    }
}
