@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Create Assignment</div>
    <div class="card-body">
        <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="file" class="form-label">Assignment File</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Assignment</button>
        </form>
    </div>
</div>
@endsection
