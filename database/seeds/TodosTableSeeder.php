<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('todos')->insert([  //← タスクを追加
            'title' => '散歩をする'
        ]);
        DB::table('todos')->insert([  //← タスクを追加
            'title' => '読書をする'
        ]);
        DB::table('todos')->insert([  //← タスクを追加
            'title' => '料理をする'
        ]);
    }
}
