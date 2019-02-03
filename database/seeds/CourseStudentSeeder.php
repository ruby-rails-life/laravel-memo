<?php

use Illuminate\Database\Seeder;
use App\Student;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('course_student')->delete();
    	DB::table('students')->delete();
        
        $faker = Faker\Factory::create('ja_JP');

    	for( $i = 1 ; $i <= 3 ; $i++) {
            Student::create([
                'name' => $faker->name
            ]);
    	}

    	DB::table('course_student')->insert([
    		['student_id' => 1, 'course_id' => 1],
    		['student_id' => 1, 'course_id' => 2],
    		['student_id' => 2, 'course_id' => 2],
    	]);
    }
}
