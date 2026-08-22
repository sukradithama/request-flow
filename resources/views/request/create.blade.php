@extends('layouts.app')
@section('title','Request Dashboard')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Create Request</h5>
        </div>

        <div class="card-body">
            <form action="{{route('StoreRequest')}}" method="POST">
                @csrf
                <!-- Category -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">
                        Category
                    </label>

                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->category }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- User -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">
                        User
                    </label>

                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">-- Select User --</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Assigned To -->
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">
                        Assigned To
                    </label>

                    <select name="assigned_to" id="assigned_to" class="form-select">
                        <option value="">-- Not Assigned --</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        placeholder="Enter request title">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        rows="5"
                        placeholder="Describe your request..."></textarea>
                </div>

                <!-- Priority -->
                <div class="mb-3">
                    <label for="priority" class="form-label">
                        Priority
                    </label>

                    <select name="priority" id="priority" class="form-select">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Create Request
                    </button>

                    <a href="#" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection