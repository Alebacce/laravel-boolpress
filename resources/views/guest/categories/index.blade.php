@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Lista delle categorie</h1>
        </div>

        <div class="row">
            <div class="col">
                <ul>
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('category-page', ['slug' => $category->slug ] ) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection