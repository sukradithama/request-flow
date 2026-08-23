@extends('layouts.app')

@section('title', 'Update Request')

@section('content')

<div class="container mt-4">

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Update Request</h5>
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


            <form
                action="{{ route('UpdateRequest', $requestData->slug) }}"
                method="POST">

                @csrf
                @method('PUT')


                {{-- ================= CATEGORY ================= --}}

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
                            {{ $requestData->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->category }}
                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- ================= REQUESTER ================= --}}

                @if(Auth::user()->role === 'admin')

                <div class="mb-3">

                    <label for="user_id" class="form-label">
                        Requester
                    </label>

                    <select
                        name="user_id"
                        id="user_id"
                        class="form-select">

                        @foreach ($users as $user)

                        <option
                            value="{{ $user->id }}"
                            {{ $requestData->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>

                        @endforeach

                    </select>

                </div>

                @else

                {{-- Requester hanya melihat dirinya sendiri --}}

                <div class="mb-3">

                    <label class="form-label">
                        Requester
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $requestData->user->name }}"
                        disabled>

                </div>

                @endif


                {{-- ================= ASSIGNED TO ================= --}}

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

                        @foreach ($users as $user)

                        @if($user->role === 'staff')

                        <option
                            value="{{ $user->id }}"
                            {{ $requestData->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>

                        @endif

                        @endforeach

                    </select>

                </div>

                @else

                {{-- Staff/Requester hanya melihat assignment --}}

                <div class="mb-3">

                    <label class="form-label">
                        Assigned To
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $requestData->assignee?->name ?? 'Not Assigned' }}"
                        disabled>

                </div>

                @endif


                {{-- ================= TITLE ================= --}}

                <div class="mb-3">

                    <label for="title" class="form-label">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="{{ old('title', $requestData->title) }}"
                        placeholder="Enter request title"
                        required>

                </div>


                {{-- ================= DESCRIPTION ================= --}}

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
                        required>{{ old('description', $requestData->description) }}</textarea>

                </div>


                {{-- ================= PRIORITY ================= --}}

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
                            {{ $requestData->priority == 'low' ? 'selected' : '' }}>
                            Low
                        </option>

                        <option
                            value="medium"
                            {{ $requestData->priority == 'medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option
                            value="high"
                            {{ $requestData->priority == 'high' ? 'selected' : '' }}>
                            High
                        </option>

                        <option
                            value="critical"
                            {{ $requestData->priority == 'critical' ? 'selected' : '' }}>
                            Critical
                        </option>

                    </select>

                </div>


                {{-- ================= BUTTON ================= --}}

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Update Request
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