<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\TodoList;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;

class TodoListTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * test get all to-do lists
     */
    public function testGetAllTodoLists()
    {
        $response = $this->get('/todolist/all');

        $response->assertStatus(200);
        $this->assertIsNotArray($response);
        $this->assertInstanceOf(TestResponse::class, $response);        
    }

    /**
     * test get all to-do by user Id
     */
    public function testGetTodoListsByUserId()
    {
        $response = $this->json(
            'GET',
            '/todolist/by-user',
            ["userId" => 1]
        );

        $response->assertStatus(200);
        $this->assertIsNotArray($response);
        $this->assertInstanceOf(TestResponse::class, $response);
    }

    /**
     * test create new to-do list
     */
    public function testCreateNewTodoList()
    {
        $response = $this->post('/todolist/create', [
            "userId" => 1,
            "name" => "testeDummy4",
            "description" => "testeDummy2"
        ]);

        $response->assertStatus(201);
        $this->assertInstanceOf(TestResponse::class, $response);
    }

    /**
     * delete to-do list
     */
    public function testDeleteTodoListByName()
    {
        $response = $this->delete('/todolist/delete/3');

        $response->assertStatus(200);
        $this->assertInstanceOf(TestResponse::class, $response);
    }
}
