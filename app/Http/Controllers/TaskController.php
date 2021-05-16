<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Http\Response;
use \Validator;

class TaskController extends Controller 
{   
    /**
     *
     * @var App\Services\BrandService
     */
    public function __construct(TaskService $service) 
    {
        $this->service = $service;
    }

    /**
     * get all to-do lists
     * 
     * @param Request $request
     */
    public function getAllTasks(Request $request)
    {
        $result = $this->service->getAllTasks();

        return $result;
    }

    /**
     * get all tasks by to-do list
     * 
     * @param Request $request
     */
    public function getAllTasksByTodoList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'todoId' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $result = $this->service->getAllTasksByTodoList($request->input('todoId'));

        if (gettype($result) === "string") {
            return response()->json($result, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }
      
    /**
     * create new task
     * 
     * @param Request $request
     */
    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'todoListId' => 'required|int',
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $result = $this->service->createTask($request->all());

        if (gettype($result) === "string") {
            return response()->json($result, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    /**
     * create new task
     * 
     * @param Request $request
     * @param int $taskId
     */
    public function updateTask(Request $request, int $taskId)
    {
        $validator = Validator::make($request->all(), [
            'todoListId' => 'int|required',
            'title' => 'string|required',
            'description' => 'string|required',
            'statusId' => 'int|required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $result = $this->service->updateTask($request->all(), $taskId);

        if (gettype($result) === "string") {
            return response()->json($result, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    
    public function deleteTask(Request $request, int $taskId)
    {
        $result = $this->service->deleteTask($taskId);

        return $result;
    }
    
}