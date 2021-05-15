<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

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

// Route::prefix('todolist')
//     ->middleware('auth')
//     ->group(function ($router) {
//         $router->get('all', 'TodoListController@getAllTodoLists');
//         $router->get('by-user/{id}', 'TodoListController@getAllTodoListsByUser');
//         $router->post('create', 'TodoListController@createTodoList');
//         $router->delete('delete/{id}', 'TodoListController@deleteTodoList');
//     });

    Route::get('todolist/all', [TodoListController::class, 'getAllTodoLists']);
    Route::get('todolist/by-user', [TodoListController::class, 'getAllTodoListsByUser']);
    Route::post('todolist/create', [TodoListController::class, 'createTodoList']);
    Route::delete('todolist/delete/{id}', [TodoListController::class, 'deleteTodoList']);

Route::prefix('tasks')
    ->middleware('auth')
    ->group(function ($router) {
        $router->get('all', 'TaskController@getAllTodoLists');
        $router->get('by-todo-list/{id}', 'TaskController@getAllTodoListsByUser');
        $router->post('create', 'TaskController@createTodoList');
        $router->put('update/{id}', 'TaskController@updateTodoList');
        $router->delete('delete/{id}', 'TaskController@deleteTodoList');
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
