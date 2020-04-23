<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tag;

class TagController extends Controller
{
    public function search(Request $request) {
        $res = Tag::where('tag_name', 'like' , $request->search_string . '%')->get(['id', 'tag_name']);
        return $res;
    }
}
