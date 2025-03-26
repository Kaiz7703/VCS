@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Assignments</span>
        @if(Auth::user()->isTeacher())
            <a href="{{ route('assignments.create') }}" class="btn btn-primary">Create Assignment</a>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Teacher</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ $assignment->teacher->name }}</td>
                        <td>{{ $assignment->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
