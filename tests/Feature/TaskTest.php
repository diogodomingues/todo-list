<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithoutMiddleware;
    
    /**
     * test get all tasks
     */
    public function testGetAllTasks()
    {
        $response = $this->get('/tasks/all');

        $response->assertStatus(200);
        $this->assertIsNotArray($response);
        $this->assertInstanceOf(TestResponse::class, $response); 
    }

    /**
     * test get all tasks by to-do list
     */
    public function testGetAllTasksByTolist()
    {
        $response = $this->json(
            'GET',
            '/tasks/by-todo-list',
            ["todoId" => 1]
        );

        $response->assertStatus(200);
        $this->assertIsNotArray($response);
        $this->assertInstanceOf(TestResponse::class, $response); 
    }

    /**
     * test create new task
     */
    public function testCreateNewTask()
    {
        $response = $this->post('/tasks/create', [
            "todoListId" => 1,
            "title" => "testeDummyTask",
            "description" => "testeDummyTask"
        ]);

        $response->assertStatus(201);
        $this->assertInstanceOf(TestResponse::class, $response);
    }

    /**
     * test update task
     */
    public function testUpdateTask()
    {
        $response = $this->put('/tasks/update/1', [
            "todoListId" => 1,
            "title" => "testeDummyUpdate",
            "description" => "testeDummyUpdated",
            "statusId" => 3
        ]);

        $response->assertStatus(200);
        $this->assertInstanceOf(TestResponse::class, $response);
    }

    /**
     * delete task
     */
    public function testDeleteTask()
    {
        $response = $this->delete('/tasks/delete/1');

        $response->assertStatus(200);
        $this->assertInstanceOf(TestResponse::class, $response);
    }
}
