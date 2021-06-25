<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fakepost;

class PostController extends Controller
{
    public function index()
    {
        $posts = Fakepost::all();

        $posts_for_response = [];
        foreach($posts as $post) {
            $posts_for_response[] = [
                'id' => $post->id,
                'title' => $post->title,
                'author' => $post->author,
                'content' => $post->content,
                'category' => $post->category ? $post->category->name : '',
                'tags' => $post->tags->toArray()
            ];
        };

        $result = [
            'posts' => $posts,
            'success' => true
        ];

        return response()->json($posts_for_response);
    }
}
