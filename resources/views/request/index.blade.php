@extends('layouts.app')
@section('title','Request Dashboard')

@section('content')
<div class="container">
    <div class="card mt-5">
        <div class="d-flex justify-content-between card-header">
            Daftar Request
            <a href="{{route('CreateRequest')}}" class="btn btn-success btn-sm"><i class="bi bi-plus-circle-fill"></i></a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Request</th>
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
                    <?php $x = 1; ?>
                    @foreach($requests as $request)
                    <tr>
                        <td><?php echo $x++; ?></td>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->category->category }}</td>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ $request->assignee?->name }}</td>
                        <td>{{ $request->title }}</td>
                        <td><span class="badge text-bg-danger">{{ $request->status }}</span></td>
                        <td><span class="badge text-bg-info">{{ $request->priority }}</span></td>
                        <td>{{ $request->created_at }}</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{$request->id}}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <!-- Show Modal -->
                            <div class="modal fade" id="modal{{$request->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-body">

                                                <div class="row g-3">

                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">ID Request</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->id }}
                                                        </p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">Name</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->user->name }}
                                                        </p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">Email</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->user->email }}
                                                        </p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">Status</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->status }}
                                                        </p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">Status</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->priority }}
                                                        </p>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Subject</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->subject }}
                                                        </p>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-bold">Description</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->description }}
                                                        </p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">Created At</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->created_at }}
                                                        </p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label fw-bold">Updated At</label>
                                                        <p class="form-control-plaintext">
                                                            {{ $request->updated_at }}
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Show Modal -->
                            <button type="button" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection