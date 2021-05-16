<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('title of the task');
            $table->string('description')->comment('description of the task');

            $table->bigInteger('todo_list_id')->unsigned()->comment('todo_list id of the task');;
            $table->foreign('todo_list_id')->references('id')->on('todo_lists');

            $table->bigInteger('status_id')->unsigned()->comment('status of the task');;
            $table->foreign('status_id')->references('id')->on('tasks_status');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
