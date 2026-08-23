@extends('layouts.app')

@section('title', 'Create Request')

@section('content')

<div class="container mt-4">

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Create Request</h5>
        </div>

        <div class="card-body">

            {{-- Validation Error --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <form action="{{ route('StoreRequest') }}" method="POST">

                @csrf


                {{-- Category --}}
                <div class="mb-3">

                    <label for="category_id" class="form-label">
                        Category
                    </label>

                    <select
                        name="category_id"
                        id="category_id"
                        class="form-select"
                        required>

                        <option value="">
                            -- Select Category --
                        </option>

                        @foreach ($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- Requester --}}
                <div class="mb-3">

                    <label class="form-label">
                        Requester
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ Auth::user()->name }}"
                        disabled>

                    {{-- user_id tidak dikirim dari form --}}
                    {{-- Controller menggunakan Auth::id() --}}

                </div>


                {{-- Assigned To --}}
                @if(Auth::user()->role === 'admin')

                <div class="mb-3">

                    <label for="assigned_to" class="form-label">
                        Assigned To
                    </label>

                    <select
                        name="assigned_to"
                        id="assigned_to"
                        class="form-select">

                        <option value="">
                            -- Not Assigned --
                        </option>

                        @foreach($users as $user)

                        @if($user->role === 'staff')

                        <option
                            value="{{ $user->id }}"
                            {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>

                        @endif

                        @endforeach

                    </select>

                </div>

                @endif


                {{-- Title --}}
                <div class="mb-3">

                    <label for="title" class="form-label">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="{{ old('title') }}"
                        placeholder="Enter request title"
                        required>

                </div>


                {{-- Description --}}
                <div class="mb-3">

                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="5"
                        placeholder="Describe your request..."
                        required>{{ old('description') }}</textarea>

                </div>


                {{-- Priority --}}
                <div class="mb-3">

                    <label for="priority" class="form-label">
                        Priority
                    </label>

                    <select
                        name="priority"
                        id="priority"
                        class="form-select"
                        required>

                        <option
                            value="low"
                            {{ old('priority') == 'low' ? 'selected' : '' }}>
                            Low
                        </option>

                        <option
                            value="medium"
                            {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option
                            value="high"
                            {{ old('priority') == 'high' ? 'selected' : '' }}>
                            High
                        </option>

                        <option
                            value="critical"
                            {{ old('priority') == 'critical' ? 'selected' : '' }}>
                            Critical
                        </option>

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Create Request
                    </button>

                    <a
                        href="{{ route('IndexRequest') }}"
                        class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection