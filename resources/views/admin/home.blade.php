@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Welcome on board!</h1>
            <div class="card">
                <div class="card-body">
                    <h2>Ciao {{ $current_user->name }}!</h2>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Hai effettuato correttamente il log-in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
