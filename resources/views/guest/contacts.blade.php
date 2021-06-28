@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>
            Contattaci compilando il form
        </h1>

        <form action="{{ route('handle-new-contact') }}" method="post">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="message">Messaggio</label>
                <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
            </div>

            <input class="btn btn-success" type="submit" value="Invia messaggio">
        </form>
    </div>
@endsection