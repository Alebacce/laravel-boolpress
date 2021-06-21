@extends('layouts.app')

@section('title_tag')
    L'archivio nerd: Archivia Fumetto
@endsection

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
        <h1>Inserisci un nuovo post</h1>
        <div class="row">
            <div class="col-4">
                {{-- Nuovo Articolo --}}
                <form action="{{ route('admin.posts.store') }}" method="post">
                @csrf
                @method('POST')

                <label for="title">Titolo</label>
                <input type="text" name="title" id="title" value="{{ $post->title }}">
                
                <label for="author">Autore</label>
                <input type="text" name="author" id="author" value="{{ $post->author }}">

                <label for="content">Post</label>
                <textarea name="content" id="content" cols="30" rows="10">{{ $post->content }}</textarea>

                <input type="submit" value="Modifica">
            </div>
        </div>
    </div>

</form>
@endsection