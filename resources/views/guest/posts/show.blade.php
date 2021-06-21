@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{$post->title}}</h1>

        <h6>
            {{$post->author}}
        </h6>

        <p>
            {{$post->content}}
        </p>
    </div>    
@endsection