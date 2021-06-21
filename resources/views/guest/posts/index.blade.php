@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Laravel's blog</h1>

        <div class="row">
            @foreach ($posts as $post)
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text">{{ $post->author }}</p>
                            <p class="card-text">{{ $post->content }}</p>
                        </div>

                        <div class="btn-container">
                            {{-- Show --}}
                            {{-- Passo lo slug come parametro anziché l'id --}}
                            <a href="{{ route('blog-page', [ 'slug' => $post->slug ]) }}" class="btn btn-primary">Leggi</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>    
@endsection