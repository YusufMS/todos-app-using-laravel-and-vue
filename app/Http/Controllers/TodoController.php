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
    public function index()
    {
        // To be modified to get only items of Auth user
        $todos = Todo::orderBy('created_at', 'desc')->with('tags')->paginate(5);

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
            'title' => 'required|string|min:3',
            'description' => 'required'
            ]);
            
        $todo = new Todo;
        $todo->title = $request->title;
        $todo->description = $request->description;
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
        //
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
