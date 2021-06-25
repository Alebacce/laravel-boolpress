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
            $tags = $post->tags->toArray();
            $return_tags = [];

            foreach($tags as $tag) {
                $return_tags[] = [
                    'name' => $tag['name']
                ];
            }

            $posts_for_response[] = [
                'id' => $post->id,
                'title' => $post->title,
                'author' => $post->author,
                'content' => $post->content,
                'category' => $post->category ? $post->category->name : '',
                'tags' => $return_tags
            ];
        };

        $result = [
            'posts' => $posts,
            'success' => true
        ];

        return response()->json($posts_for_response);
    }
}
