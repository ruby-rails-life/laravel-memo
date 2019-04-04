<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = new \App\Project([
            'project_name' => '幼稚園管理システム',
            'sales_staff_id' => 3,
            'project_status' => '1'
        ]);
        $project->save();
    }
}
