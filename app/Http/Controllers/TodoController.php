<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Tag;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // To be modified to get only items of Auth user

        $todos = Todo::where('todo_item', 'like', '%' . $request->search_string . '%')->orderBy('created_at', 'desc')->with('tags')->paginate(5);
        $todos = json_encode($todos);
        return $todos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'todo_item' => 'required|string|min:3',
            // 'completed' => 'required|boolean'
            ]);

        $todo = new Todo;
        $todo->todo_item = $request->todo_item;
        // DB Accepting null value for UID to be changed in PHP MyAdmin
        $todo->save();

        foreach ($request->tags as $tag_name) {
            $tag = Tag::firstOrCreate(['tag_name' => strtolower($tag_name)]);
            $todo->tags()->attach($tag, ['created_at' => now(), 'updated_at' => now()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return $todo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        if ($request->type == 'toggle_complete') {
            $todo->completed = !($todo->completed);
            $todo->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
    }
}
