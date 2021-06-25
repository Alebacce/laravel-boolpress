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

        $result = [
            'posts' => $posts,
            'success' => true
        ];

        return response()->json($result);
    }
}
