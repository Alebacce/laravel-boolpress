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
    </div>    
@endsection