<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tasksStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks_status')->insert([
            'code' => 'To-do',
            'description' => 'Task not initiated',
            'created_at' =>  \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('tasks_status')->insert([
            'code' => 'Initialized',
            'description' => 'Start working on task',
            'created_at' =>  \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('tasks_status')->insert([
            'code' => 'In Development',
            'description' => 'Working hard to complete the task',
            'created_at' =>  \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('tasks_status')->insert([
            'code' => 'Completed',
            'description' => 'Completed the task',
            'created_at' =>  \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        DB::table('tasks_status')->insert([
            'code' => 'Cancelled',
            'description' => 'Cancelled task',
            'created_at' =>  \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}
