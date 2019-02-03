<?php

use Illuminate\Database\Seeder;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1レコード
        $course = new \App\Course([
            'name' => 'PHP'
        ]);
        $course->save();

        // 2レコード
        $course = new \App\Course([
        'name' => 'JavaScript'
        ]);
        $course->save();
    }
}
