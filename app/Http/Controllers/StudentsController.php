<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Course;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('student.create', ['students' => Student::all(), 'courses' => Course::all()]);
    }

    public function store(Request $request)
    {
        $validateRules = [
            'name'=>'required'
        ];
 
        $validateMessages = [
            "required" => "必須項目です。"
        ];
 
        $this->validate($request, $validateRules, $validateMessages);

        $student = new Student();
        $student->name = request()->name;
        $student->save();
        $student->courses()->attach(request()->courses);
        return redirect('/students');
    }
}
