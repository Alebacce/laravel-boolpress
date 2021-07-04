<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        $data = [
            'tags' => $tags
        ];

        return view('guest.tags.index', $data);
    }

    public function show($slug)
    {
        $tag = Tag::where('slug', '=', $slug)->first();

        if(!$tag) {
            abort('404');
        }

        $data = [
            'tag' => $tag,
        ];

        return view('guest.tags.show', $data);
    }
}
