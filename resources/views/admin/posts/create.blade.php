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
                <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="content">Contenuto</label>
                    <textarea class="form-control" id="content" name="content" rows="10">{{ old('content') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="category_id">Categoria</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">Nessuna</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"  {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach                        
                    </select>
                </div>

                <div class="form-group">
                    <h6>Tags</h6>
                    @foreach ($tags as $tag)
                        <div class="form-check">
                            {{-- Rendo id e for univoci per ipovedenti, i quali cliccano la label e non il quadratino della checkbox --}}
                            {{-- Non c'è la colonna per il name, per cui colleziono i vari id in un array --}}
                            {{-- All'invio sbagliato del form torno l'array corrente, quindi quello selezionato, contenuto in old('tags') 
                                mettendogli checked, altrimenti un array vuoto se nulla era stato selezionato sfruttando la funzione in_array.
                                Praticamente, se esiste old('tags') metti checked ad esso, altrimenti in un array vuoto non mettere nulla--}}
                        <input class="form-check-input" name="tags[]" type="checkbox" value="{{ $tag->id }}" id="tag-{{ $tag->id }}" {{ in_array($tag->id,  old('tags', []),) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="cover-image">Immagine di copertina</label>
                    <input type="file" class="form-control-file" name="cover-image" id="cover-image">
                </div>

                <input class="btn btn-success" type="submit" value="Aggiungi">
            </div>
        </div>
    </div>

</form>
@endsection