@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')

<div class="container mt-5">
    <div class="text-center">

        <h1 class="display-1 fw-bold">
            404
        </h1>

        <h3>
            Page Not Found
        </h3>

        <p class="text-muted">
            The page or request you are looking for
            could not be found.
        </p>

        <a
            href="{{ route('IndexRequest') }}"
            class="btn btn-primary"
        >
            Back to Requests
        </a>

    </div>
</div>

@endsection