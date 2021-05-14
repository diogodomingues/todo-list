<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TodoListService;

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

    public function getAllTodoLists(Request $request)
    {
        $result = $this->service->getAllTodoLists();

        return $result;
    }

    public function getAllTodoListsByUser(Request $request)
    {
        $result = $this->service->getAllTodoListsByUser();

        return $result;
    }
    
}