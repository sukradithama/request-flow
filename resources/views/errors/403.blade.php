@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')

<div class="container mt-5">
    <div class="text-center">

        <h1 class="display-1 fw-bold">
            403
        </h1>

        <h3>
            Access Denied
        </h3>

        <p class="text-muted">
            You do not have permission to access this page.
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