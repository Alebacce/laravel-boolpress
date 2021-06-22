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
    </div>    
@endsection