@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Challenges</span>
        @if(Auth::user()->isTeacher())
            <a href="{{ route('challenges.create') }}" class="btn btn-primary">Create Challenge</a>
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
                    @foreach($challenges as $challenge)
                    <tr>
                        <td>{{ $challenge->title }}</td>
                        <td>{{ $challenge->teacher->name }}</td>
                        <td>{{ $challenge->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('challenges.show', $challenge) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
