@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Categories --}}
        @if($post_category)
        <div class="mt-2 mb-2">Categoria: {{ $post_category->name }}</div>
        @endif

        {{-- Info --}}
        <h1>{{$post->title}}</h1>

        <h6>
            {{$post->author}}
        </h6>

        <h6>
            <strong>Slug:</strong> {{$post->slug}}
        </h6>
        
        @if($post->cover) 
            <div class="post-img mt-2 mb-2">
            {{-- L'immagine si trova nella copia in public di storage, la link utilizzando
                asset così vado in public e collego a storage/ il path dell'immagine, che è appunto
                $post->cover--}}
            <img src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}">
        </div>
        @endif

        <p>
            {{$post->content}}
        </p>

        {{-- Tags --}}
        @if($post_tags->isNotEmpty())
        <div class="mt-2 mb-2">
            <strong>Tag:</strong> 
            @foreach ($post_tags as $tag)
                {{ $tag->name }}{{$loop->last ? '' : ', '}}
            @endforeach    
        </div>
        @endif

        {{-- Edit --}}
        <a href="{{ route('admin.posts.edit', ['post' => $post->id ]) }}" class="btn btn-secondary">
            Modifica dati
        </a>

        {{-- Delete --}}
        <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
            @csrf
            @method('DELETE')

            <input type="submit" class="btn btn-danger" value="Cancella" onclick="return confirm('Sei sicuro di voler eliminare l\'elemento?')">
        </form>
    </div>    
@endsection