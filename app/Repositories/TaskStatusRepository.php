<?php

namespace App\Repositories;

use App\Models\TasksStatus;

class TaskStatusRepository extends Repository
{
    /**
     * Constructor
     */
    public function __construct(TasksStatus $tasksStatus)
    {
        $this->model = $tasksStatus;
    }

    /**
     * Return all tasksStatus available
     * 
     * @return Collection
     */
    public function getAllTasksStatus(): \Illuminate\Support\Collection
    {
        return $this->model::get();
    }

    /**
     * Return a taskStatus by it's ID
     * 
     * @param int $taskStatusId
     * 
     * @return mixed
     */
    public function getTasksStatusById(int $taskStatusId)
    {
        return $this->model::where('id', '=', $taskStatusId)
            ->first();
    }

    /**
     * Return a taskStatus by it's code
     * 
     * @param string $code
     * 
     * @return TasksStatus
     */
    public function getTasksStatusByCode(string $code): TasksStatus
    {
        return $this->model::where('code', '=', $code)->first();
    }
    
}
