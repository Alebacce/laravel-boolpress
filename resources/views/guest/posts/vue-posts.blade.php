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

            <div class="row">
                <div v-for="post in posts" class="col-6 vue-posts">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@{{ post.title }}</h5>
                            <h6 class="card-title">@{{ post.author }}</h6>
                            <p class="card-text">@{{ post.content }}</p>

                            <div v-if="post.tags.length > 0">
                                Tags:
                            <ul>
                                <li v-for="tag in post.tags">
                                    @{{ tag.name }}
                                </li>
                            </ul>
                            </div>
                            {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>    
@endsection

@section('footer-scripts')
    <script src="{{ asset('js/posts.js') }}"></script>
@endsection