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
            <div class="col">
                {{-- Nuovo Articolo --}}
                <form action="{{ route('admin.posts.store') }}" method="post">
                @csrf
                @method('POST')
                

                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                </div>

                <div class="form-group">
                    <label for="author">Autore</label>
                    <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}">
                </div>

                <div class="form-group">
                    <label for="content">Example textarea</label>
                    <textarea class="form-control" id="content" name="content" rows="10">{{ old('content') }}</textarea>
                </div>

                <input class="btn btn-success" type="submit" value="Aggiungi">
            </div>
        </div>
    </div>

</form>
@endsection