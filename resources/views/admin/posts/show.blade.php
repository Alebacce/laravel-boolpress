@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{$post->title}}</h1>

        <div>
            {{$post->author}}
        </div>

        <p>
            {{$post->content}}
        </p>
    </div>    
@endsection