@extends('layouts.app')

@section('title', 'Request Dashboard')

@section('content')

<div class="container">
    {{-- Dashboard Summary --}}
    <div class="row g-3 mt-4">

        {{-- Total --}}
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        Total
                    </h6>

                    <h3 class="mb-0">
                        {{ $total }}
                    </h3>
                </div>
            </div>
        </div>


        {{-- Pending --}}
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        Pending
                    </h6>

                    <h3 class="mb-0">
                        {{ $pending }}
                    </h3>
                </div>
            </div>
        </div>


        {{-- In Progress --}}
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        In Progress
                    </h6>

                    <h3 class="mb-0">
                        {{ $inProgress }}
                    </h3>
                </div>
            </div>
        </div>


        {{-- Completed --}}
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        Completed
                    </h6>

                    <h3 class="mb-0">
                        {{ $completed }}
                    </h3>
                </div>
            </div>
        </div>


        {{-- High Priority --}}
        <div class="col-md">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">
                        High Priority
                    </h6>

                    <h3 class="mb-0">
                        {{ $highPriority }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    <form
        action="{{ route('IndexRequest') }}"
        method="GET"
        class="mt-3">

        <div class="row g-2">

            {{-- Search --}}
            <div class="col-md-4">

                <label for="search" class="form-label">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="form-control"
                    placeholder="Search request..."
                    value="{{ $search ?? '' }}">

            </div>


            {{-- Status --}}
            <div class="col-md-2">

                <label for="status" class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-select">

                    <option value="">
                        All
                    </option>

                    <option
                        value="pending"
                        {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option
                        value="in_progress"
                        {{ ($status ?? '') === 'in_progress' ? 'selected' : '' }}>
                        In Progress
                    </option>

                    <option
                        value="resolved"
                        {{ ($status ?? '') === 'resolved' ? 'selected' : '' }}>
                        Resolved
                    </option>

                    <option
                        value="rejected"
                        {{ ($status ?? '') === 'rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>

                </select>

            </div>


            {{-- Priority --}}
            <div class="col-md-2">

                <label for="priority" class="form-label">
                    Priority
                </label>

                <select
                    name="priority"
                    id="priority"
                    class="form-select">

                    <option value="">
                        All
                    </option>

                    <option
                        value="critical"
                        {{ ($priority ?? '') === 'critical' ? 'selected' : '' }}>
                        Critical
                    </option>

                    <option
                        value="high"
                        {{ ($priority ?? '') === 'high' ? 'selected' : '' }}>
                        High
                    </option>

                    <option
                        value="medium"
                        {{ ($priority ?? '') === 'medium' ? 'selected' : '' }}>
                        Medium
                    </option>

                    <option
                        value="low"
                        {{ ($priority ?? '') === 'low' ? 'selected' : '' }}>
                        Low
                    </option>

                </select>

            </div>


            {{-- Category --}}
            <div class="col-md-2">

                <label for="category_id" class="form-label">
                    Category
                </label>

                <select
                    name="category_id"
                    id="category_id"
                    class="form-select">

                    <option value="">
                        All
                    </option>

                    @foreach ($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ ($categoryId ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->category }}
                    </option>

                    @endforeach

                </select>

            </div>


            {{-- Buttons --}}
            <div class="col-md-2 d-flex align-items-end gap-2">

                <button
                    type="submit"
                    class="btn btn-primary">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

                <a
                    href="{{ route('IndexRequest') }}"
                    class="btn btn-secondary">
                    Clear
                </a>

            </div>

        </div>

    </form>
    <div class="card mt-3">

        <div class="d-flex justify-content-between align-items-center card-header">

            <span>Daftar Request</span>

            {{-- Create Request --}}
            @if(in_array(Auth::user()->role, ['requester', 'admin']))
            <a
                href="{{ route('CreateRequest') }}"
                class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle-fill"></i>
            </a>
            @endif

        </div>

        <div class="card-body">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Request</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Assigned To</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                    $x = 1;
                    @endphp

                    @foreach($requests as $request)

                    @php

                    $statusClass = match($request->status) {
                    'pending' => 'text-bg-warning',
                    'in_progress' => 'text-bg-primary',
                    'resolved' => 'text-bg-success',
                    'rejected' => 'text-bg-danger',
                    default => 'text-bg-secondary',
                    };

                    $priorityClass = match($request->priority) {
                    'critical' => 'text-bg-danger',
                    'high' => 'text-bg-warning',
                    'medium' => 'text-bg-info',
                    'low' => 'text-bg-success',
                    default => 'text-bg-secondary',
                    };

                    @endphp

                    <tr>

                        {{-- No --}}
                        <td>
                            {{ $x++ }}
                        </td>

                        {{-- ID --}}
                        <td>
                            R{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Category --}}
                        <td>
                            {{ $request->category->category }}
                        </td>

                        {{-- User --}}
                        <td>
                            {{ $request->user->name }}
                        </td>

                        {{-- Assigned To --}}
                        <td>
                            {{ $request->assignee?->name ?? 'Not Assigned' }}
                        </td>

                        {{-- Title --}}
                        <td>
                            {{ $request->title }}
                        </td>

                        {{-- Status --}}
                        <td>

                            @if(in_array(Auth::user()->role, ['staff', 'admin']))

                            <form
                                action="{{ route('UpdateRequestStatus', $request->slug) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <select
                                    name="status"
                                    class="form-select form-select-sm"
                                    onchange="this.form.submit()">

                                    <option
                                        value="pending"
                                        {{ $request->status === 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option
                                        value="in_progress"
                                        {{ $request->status === 'in_progress' ? 'selected' : '' }}>
                                        In Progress
                                    </option>

                                    <option
                                        value="resolved"
                                        {{ $request->status === 'resolved' ? 'selected' : '' }}>
                                        Resolved
                                    </option>

                                    <option
                                        value="rejected"
                                        {{ $request->status === 'rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>

                                </select>

                            </form>

                            @else

                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>

                            @endif

                        </td>

                        {{-- Priority --}}
                        <td>
                            <span class="badge {{ $priorityClass }}">
                                {{ ucfirst($request->priority) }}
                            </span>
                        </td>

                        {{-- Created At --}}
                        <td>
                            {{ $request->created_at->format('d-m-Y H:i') }}
                        </td>

                        {{-- Action --}}
                        <td>

                            {{-- Edit --}}
                            @if(in_array(Auth::user()->role, ['requester', 'admin']))
                            <a
                                href="{{ route('EditRequest', $request->slug) }}"
                                class="btn btn-success btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @endif


                            {{-- Detail --}}
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modal{{ $request->id }}">
                                <i class="bi bi-eye"></i>
                            </button>


                            {{-- Delete --}}
                            @if(Auth::user()->role === 'admin')

                            <form
                                action="{{ route('DeleteRequest', $request->slug) }}"
                                method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>

                            </form>

                            @endif

                        </td>

                    </tr>


                    {{-- ================= MODAL DETAIL ================= --}}

                    <div
                        class="modal fade"
                        id="modal{{ $request->id }}"
                        tabindex="-1"
                        aria-hidden="true">

                        <div class="modal-dialog modal-lg">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">
                                        Request R{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}
                                    </h5>

                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"></button>

                                </div>

                                <div class="modal-body">

                                    <div class="row g-3">

                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Requester
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->user->name }}
                                            </p>

                                        </div>


                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Email
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->user->email }}
                                            </p>

                                        </div>


                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Category
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->category->category }}
                                            </p>

                                        </div>


                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Assigned To
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->assignee?->name ?? 'Not Assigned' }}
                                            </p>

                                        </div>


                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Status
                                            </label>

                                            <p class="form-control-plaintext">
                                                <span class="badge {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                </span>
                                            </p>

                                        </div>


                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Priority
                                            </label>

                                            <p class="form-control-plaintext">
                                                <span class="badge {{ $priorityClass }}">
                                                    {{ ucfirst($request->priority) }}
                                                </span>
                                            </p>

                                        </div>


                                        <div class="col-12">

                                            <label class="form-label fw-bold">
                                                Title
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->title }}
                                            </p>

                                        </div>


                                        <div class="col-12">

                                            <label class="form-label fw-bold">
                                                Description
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->description }}
                                            </p>

                                        </div>


                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Created At
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->created_at->format('d-m-Y H:i') }}
                                            </p>

                                        </div>


                                        <div class="col-md-6">

                                            <label class="form-label fw-bold">
                                                Updated At
                                            </label>

                                            <p class="form-control-plaintext">
                                                {{ $request->updated_at->format('d-m-Y H:i') }}
                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection