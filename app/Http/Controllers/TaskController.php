<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TodoListService;

class TaskController extends Controller 
{   
    /**
     *
     * @var App\Services\BrandService
     */
    public function __construct(TodoListService $service) 
    {
        $this->service = $service;
    }
    
}