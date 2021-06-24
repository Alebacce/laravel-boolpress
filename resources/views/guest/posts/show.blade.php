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

        <p>
            {{$post->content}}
        </p>


        {{-- Tags --}}
        @if($post_tags)
        <div class="mt-2 mb-2">
            <strong>Tag:</strong> 
            @foreach ($post_tags as $tag)
                {{ $tag->name }}{{$loop->last ? '' : ', '}}
            @endforeach    
        </div>
        @endif
    </div>    
@endsection