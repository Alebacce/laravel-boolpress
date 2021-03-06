@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista dei tag</h1>

        <ul>
            @foreach ($tags as $tag)
                <li>
                    <a href="{{ route('tags-page', ['slug' => $tag->slug]) }}">
                        {{ $tag->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection