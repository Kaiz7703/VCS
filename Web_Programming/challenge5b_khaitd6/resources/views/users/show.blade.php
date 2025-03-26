@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>User Details</span>
                @if(Auth::id() !== $user->id)
                    <a href="{{ route('messages.show', $user) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-comments me-1"></i> Send Message
                    </a>
                @endif
            </div>
            <div class="card-body">
                <h5>{{ $user->name }}</h5>
                <p>Email: {{ $user->email }}</p>
                <p>Phone: {{ $user->phone ?? 'Not set' }}</p>
                <p>Role: {{ ucfirst($user->role->name) }}</p>
                @if(Auth::user()->isTeacher() || Auth::id() === $user->id)
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
