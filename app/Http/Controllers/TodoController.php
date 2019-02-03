<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodoController extends Controller
{
    public function getTodos()
    {
        $todos = Todo::all();
        return $todos;
    }

    public function addTodo(Request $request)
    {
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->save();

        $todos = Todo::all();
        return $todos;
    }

    public function deleteTodo(Request $request){  //←追記
        $todo = Todo::where('id', $request->id)->delete();

        $todos = Todo::all();
        return $todos;
    }
}
