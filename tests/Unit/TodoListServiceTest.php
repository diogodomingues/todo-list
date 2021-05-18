<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use App\Repositories\TodoListRepository;
use Illuminate\Support\Collection;
use App\Services\TodoListService;
use App\Models\TodoList;

class TodoListServiceTest extends TestCase
{
    use WithoutMiddleware;

    protected $todoListRepository;
    protected $todoListService;

    protected function setUp(): void
    {
        //required to initialize app instance
        parent::setUp();

        $this->todoListRepository = $this->mock(TodoListRepository::class);
        $this->todoListService = app(TodoListService::class);
    }

    /**
     * test get all to-do lists
     */
    public function testGetAllTodoLists()
    {
        $returnedResult = new Collection();

        $this->todoListRepository
            ->shouldReceive("getAllTodoLists")
            ->once()
            ->andReturn($returnedResult);

        $result = $this->todoListService->getAllTodoLists();

        $this->assertInstanceOf(Collection::class, $result);
    }

    /**
     * test get all to-do by user Id
     */
    public function testGetTodoListsByUserId()
    {
        $returnedResult = new Collection();

        $this->todoListRepository
            ->shouldReceive("getAllTodoListsByUser")
            ->withAnyArgs()
            ->once()
            ->andReturn($returnedResult);

        $result = $this->todoListService->getAllTodoListsByUser(1);

        $this->assertInstanceOf(Collection::class, $result);
    }

    /**
     * test create new to-do list
     */
    public function testCreateNewTodoList()
    {
        $data = [
            "userId" => 1,
            "name" => "teste4",
            "description" => "teste4"
        ];

        $returnedResult = new TodoList();

        $this->todoListRepository
            ->shouldReceive("createTodoList")
            ->withAnyArgs()
            ->once()
            ->andReturn($returnedResult);

        $result = $this->todoListService->createTodoList($data);

        $this->assertInstanceOf(TodoList::class, $result);
    }

    /**
     * test delete to-do list
     */
    public function testDeleteTodoList()
    {
        $this->todoListRepository
            ->shouldReceive("deleteTodoList")
            ->withAnyArgs()
            ->once()
            ->andReturn(true);

        $result = $this->todoListService->deleteTodoList(1);

        $this->assertTrue($result);
    }
}
