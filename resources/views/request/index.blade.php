@extends('layouts.app')
@section('title','Request Dashboard')

@section('content')
<div class="container">
    <div class="card mt-5">
        <div class="d-flex justify-content-between card-header">
            Daftar Request
            <a href="{{route('CreateRequest')}}" class="btn btn-success btn-sm">Create</a>
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
                    <?php $x=1; ?>
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
                            <a href="#" class="btn btn-success btn-sm">Update</a>
                            <a href="#" class="btn btn-warning btn-sm">Detail</a>
                            <button type="button" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection