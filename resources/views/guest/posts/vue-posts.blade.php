@extends('layouts.app')

@section('header-scripts')
    <!-- Axios CDN -->
    {{-- Metto prima Axios siccome lo uso dentro Vue, è una dipendenza di Vue
        meglio che compaia prima--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <!-- Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
@endsection

@section('content')
    <div class="container">
        <h1>Printed with Vue.js</h1>
        <div id="root">
            <h2>@{{ title }}</h2>
        </div>
        
    </div>    
@endsection

@section('footer-scripts')
    <script src="{{ asset('js/posts.js') }}"></script>
@endsection