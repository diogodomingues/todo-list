<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Services\TodoListService;
use App\Services\TaskStatusService;

class TaskService extends Service
{      
    const TODOLIST_NOT_FOUND = 'To-do List not found';
    const TASK_ERROR = 'Impossible update Task. Please contact support.';

    /**
     * @var TodoListService
     */
    protected $todoListService;

    /**
     * @var TaskStatusService
     */
    protected $taskStatusService;

    public function __construct(
        TaskRepository $repository,
        TodoListService $todoListService,
        TaskStatusService $taskStatusService
    ) {
        $this->repository = $repository;
        $this->todoListService = $todoListService;
        $this->taskStatusService = $taskStatusService;
    }

    /**
     *  get all tasks
     */
    public function getAllTasks()
    {
        return $this->repository->getAllTasks();
    }

    /**
     * get all to-do lists for a given user
     */
    public function getAllTasksByTodoList(int $todoId)
    {
        $todoList = $this->todoListService->getTodoListById($todoId);

        if (!empty($todoList)) {
            return $this->repository->getAllTasksByTodoList($todoList->id);
        }

        return self::TODOLIST_NOT_FOUND;
    }

    /**
     * create new task
     */
    public function createTask(array $data)
    {
        $todoList = $this->todoListService->getTodoListById($data['todoListId']);

        //"To-do" is the initial status of all tasks
        $status = $this->taskStatusService->getTasksStatusByCode('To-do');

        if (!empty($todoList) && !empty($status)) {
            $data['statusId'] = $status->id;
            return $this->repository->createTask($data);
        }

        return self::TASK_ERROR;
    }

    /**
     * Update Task
     */
    public function updateTask(array $data, int $taskId)
    {
        //validate if to-do list is valid
        $todoList = $this->todoListService->getTodoListById($data['todoListId']);

        $task = $this->repository->getTasksById($taskId);

        //validate if status is valid
        $status = $this->taskStatusService->getTasksStatusById($data['statusId']);

        $resValidateStatus = true;

        if (!empty($todoList) && !empty($task) && !empty($status)) {
            //only validate rules from status if status of the task also change
            if ($task->status_id !== $data['statusId']) {
                //validate rules from task status
                $resValidateStatus = $this->validateStatus($task->status_id, $data['statusId']);
            }

            if ($resValidateStatus && !empty($todoList) && !empty($task)) {
                return $this->repository->updateTask($data, $task);
            }
        }

        return self::TASK_ERROR;
    }

    /**
     * Validate rules status from the task
     */
    public function validateStatus($currentStatus, $newStatus)
    {
        $default = true;
        /**
         * new status should always be different and higer than the previous, meaning the task is
         * running on the flow for the next stage and cannot get back
         */
        if ($newStatus < $currentStatus) {
            $default = false;
        }

        return $default;
    }

    /**
     * delete task
     */
    public function deleteTask(int $taskId)
    {
        return $this->repository->deleteTask($taskId);
    } 
    
}
