@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestisci i tuoi post</h1>

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
                            {{-- Passo l'id a chi serve, qui a tutti, lo vedo nella route list nel terminale chi ne ha bisogno e chi no --}}
                            {{-- Show --}}
                            <a href="{{ route('admin.posts.show', [ 'post' => $post->id ]) }}" class="btn btn-primary">Vedi post</a>
                            
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>    
@endsection