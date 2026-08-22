@extends('layouts.app')
@section('title','Request Dashboard')

@section('content')
<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            Daftar Request
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
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>R001</td>
                        <td>Equipment</td>
                        <td>John</td>
                        <td>General Affair</td>
                        <td>Alila's PC need to service.</td>
                        <td><span class="badge text-bg-warning"> In Progress</span></td>
                        <td><span class="badge text-bg-info">Medium</span></td>
                        <td>11 - 11 - 2005</td>
                        <td>11 - 11 - 2005</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm">Update</a>
                            <a href="#" class="btn btn-warning btn-sm">Detail</a>
                            <button type="button" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection