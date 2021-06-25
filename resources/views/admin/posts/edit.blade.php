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
                            {{-- Se ci sono errori nell'invio del form uso la validazione fatta con create, siccome mi mantiene bene ciò che ho selezionato
                                anche in caso di refresh in seguito a errori. Quella di edit invece, contenuta in @else, funziona bene solo per recupeare
                                i checked quando modifico la prima volta, ossia quando premo modifica su un post ed accedo al suo form di modifica,
                                ma se cambio i checked e si verifica un errore nell'invio del form, mi perde quelli modificati. Invece in questo caso
                                con la validazione del create mi recupera grazie ad old('tags', []) le modifiche fatte ai checked--}}
                            @if ($errors->any())
                                <input class="form-check-input" name="tags[]" type="checkbox" value="{{ $tag->id }}" id="tag-{{ $tag->id }}" {{ in_array($tag->id,  old('tags', []),) ? 'checked' : '' }}>
                            @else
                                {{-- {{ $post->tags->contains($tag->id) ? 'checked' : '' }} permette di vedere i tag esistenti quando premo modifica
                                post. Altrimenti anche se presenti vedrei nessun tag selezionato. Con la funzione contains verifico tutto questo.
                                Ci dice se in una relazione un Model con un id ha una relazione col Model attuale. Quindi controlliamo che l'elemento
                                con un id, quindi $tag->id l'id del o dei tag/tags, sia contenuto fra i tags, funzione del Model $post.
                                Se è contenuto mi torna true, altrimenti false. Richiamiamo l'elemento relazionato e gli diciamo quale elemento
                                deve controllare. --}}
                            <input class="form-check-input" name="tags[]" type="checkbox" value="{{ $tag->id }}" id="tag-{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'checked' : '' }}>
                            @endif
                            <label class="form-check-label" for="tag-{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <input class="btn btn-success" type="submit" value="Salva">
            </div>
        </div>
    </div>

</form>
@endsection