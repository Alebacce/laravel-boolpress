<?php

namespace App\Http\Controllers;
use App\Fakepost;

use Illuminate\Http\Request;

// È il PostController pubblico
class PostController extends Controller
{
    // Qui la pagina di index, con la lista dei post
    public function index() {
        // Chiedo le informazioni al Model...
        $posts = Fakepost::all();

        // ...e le passo
        $data = [
            'posts' => $posts
        ];

        return view('guest.posts.index', $data);
    }

    // Qui la pagina di show, con il singolo post.
    // Viene letto lo slug anziché l'id essendo pubblico
    public function show($slug) {
        // Vado a ricercare nel Model il post con lo slug
        // passato nella route. Tanto è unico, per cui va bene first
        $post = Fakepost::where('slug', '=', $slug)->first();

        // Se il post non esiste allora dai error 404
        if(!$post) {
            abort('404');
        }

        $data = [
            'post' => $post,
            'post_category' => $post->category,
            'post_tags' => $post->tags
        ];

        return view('guest.posts.show', $data);
    }

    // Funzione per la pagina Vue per vedere l'API stampata
    public function vuePosts() {
        return view('guest.posts.vue-posts');
    }
}
