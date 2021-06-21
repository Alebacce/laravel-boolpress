@extends('layouts.app')

@section('content')
    <div class="container">
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

        {{-- Edit --}}
        <a href="{{ route('admin.posts.edit', ['post' => $post->id ]) }}" class="btn btn-secondary">
            Modifica dati
        </a>
    </div>    
@endsection