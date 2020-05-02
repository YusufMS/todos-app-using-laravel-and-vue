<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Tag;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        // Get  only items of Auth user with the tags
        $todos = $request->user()->todos()->orderBy('created_at', 'desc')->with('tags');
        
        // Filter results by tags provided
        if ($request->filter_tags) {
            $todos = $todos->whereHas('tags', function (Builder $query) use ($request) {
                $query->whereIn('tag_name', $request->filter_tags);
                }
            );
        }

        // Filter results by search string provided
        if ($request->search_string) {
            $todos = $todos->where('todo_item', 'like', '%' . $request->search_string . '%');
        }

        // Filter results by selected status
        if ($request->filter_status != 'all') {
            $todos = $todos->where('completed', $request->filter_status);
        }
        
        // Retrieve result output with Pagination
        $todos = $todos->paginate(5);
        
        // JSON format the output (Additional)
        $todos = json_encode($todos);

        return $todos;
    }

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

    public function edit($todo)
    {
        return Todo::with('tags')->find($todo);
    }

    public function update(Request $request, Todo $todo)
    {
        if ($request->type == 'toggle_complete') {
            $todo->completed = !($todo->completed);
            $todo->save();
        }
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
    }
}
