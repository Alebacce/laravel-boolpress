@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Mostra la categoria solo se c'é --}}
        @if($post_category)
        <div class="mt-2 mb-2">Categoria: {{ $post_category->name }}</div>
        @endif

        <h1>{{$post->title}}</h1>

        <h6>
            {{$post->author}}
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
    </div>    
@endsection