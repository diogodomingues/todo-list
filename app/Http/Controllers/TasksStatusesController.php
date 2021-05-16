<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskStatusService;

class TasksStatusesController extends Controller 
{   
    /**
     *
     * @var App\Services\BrandService
     */
    public function __construct(TaskStatusService $service) 
    {
        $this->service = $service;
    }

    public function getAllTasksStatus()
    {
        $result = $this->service->getAllTasksStatus();

        return $result;
    }
    
}