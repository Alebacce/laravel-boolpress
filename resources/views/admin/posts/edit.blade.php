@extends('layouts.app')

@section('content')


    {{-- Per gli errori --}}
    @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
    @endif

    <div class="container">
        <h1>Modifica post: {{ $post->title }}</h1>
        <div class="row">
            <div class="col">
                {{-- Nuovo Articolo --}}
                <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('PUT')
                
                {{-- {{ old('title', $post->title) }} vuol dire al refresh del form, mostra un old se c'è stata qualche modifica,
                altrimenti mostra il normale attributo così com'era --}}
                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
                </div>

                <div class="form-group">
                    <label for="author">Autore</label>
                    <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $post->author) }}">
                </div>

                <div class="form-group">
                    <label for="content">Contenuto</label>
                    <textarea class="form-control" id="content" name="content" rows="10">{{  old('content', $post->content) }}</textarea>
                </div>

                <input class="btn btn-success" type="submit" value="Salva">
            </div>
        </div>
    </div>

</form>
@endsection