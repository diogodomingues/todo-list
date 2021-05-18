<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithoutMiddleware;
    
    /**
     * test get all to-do lists
     */
    public function testGetAllTasks()
    {
        $response = $this->get('/todolist/all');

        $response->assertStatus(200);
        $this->assertIsNotArray($response);
        $this->assertInstanceOf(TestResponse::class, $response); 
    }

    /**
     * test get all to-do lists
     */
    public function testGetAllTasksByTolist()
    {
        $response = $this->get('/todolist/all');

        $response->assertStatus(200);
        $this->assertIsNotArray($response);
        $this->assertInstanceOf(TestResponse::class, $response); 
    }
}
