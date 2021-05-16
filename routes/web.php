<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TasksStatusesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('todolist')
    ->middleware('auth')
    ->group(function ($router) {
        $router->get('/all', [TodoListController::class, 'getAllTodoLists']);
        $router->get('by-user', [TodoListController::class, 'getAllTodoListsByUser']);
        $router->post('create', [TodoListController::class, 'createTodoList']);
        $router->delete('delete/{id}', [TodoListController::class, 'deleteTodoList']);
    });

Route::prefix('tasks')
    ->middleware('auth')
    ->group(function ($router) {
        $router->get('all', [TaskController::class, 'getAllTasks']);
        $router->get('by-todo-list', [TaskController::class, 'getAllTasksByTodoList']);
        $router->post('create', [TaskController::class, 'createTask']);
        $router->put('update/{id}', [TaskController::class, 'updateTask']);
        $router->delete('delete/{id}', [TaskController::class, 'deleteTask']);
        $router->get('status/all', [TasksStatusesController::class, 'getAllTasksStatus']);
    });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
