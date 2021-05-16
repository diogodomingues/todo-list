<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TodoListService;
use Illuminate\Http\Response;
use \Validator;

class TodoListController extends Controller 
{   
    /**
     *
     * @var App\Services\TodoListService
     */
    public function __construct(TodoListService $service) 
    {
        $this->service = $service;
    }

    /**
     * get all to-do lists
     * 
     * @param Request $request
     */
    public function getAllTodoLists(Request $request)
    {
        $result = $this->service->getAllTodoLists();

        return $result;
    }

    /**
     * get all to-do lists by user
     * 
     * @param Request $request
     */
    public function getAllTodoListsByUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        $result = $this->service->getAllTodoListsByUser($request->input('userId'));

        if (gettype($result) === "string") {
            return response()->json($result, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    /**
     * create new todo-list
     * 
     * @param Request $request
     */
    public function createTodoList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|int',
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $result = $this->service->createTodoList($request->all());

        if (gettype($result) === "string") {
            return response()->json($result, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
    }

    /**
     * delete todo-list
     * 
     * @param Request $request
     */
    public function deleteTodoList(Request $request, int $todoId)
    {
        $result = $this->service->deleteTodoList($todoId);

        return $result;
    }
    
}