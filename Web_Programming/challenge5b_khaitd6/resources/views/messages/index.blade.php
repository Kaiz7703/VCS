@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Conversations</h5>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($conversations as $user)
                        <a href="{{ route('messages.show', $user) }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    @if($user->unread_count > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $user->unread_count }}</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ ucfirst($user->role->name) }}</small>
                            </div>
                        </a>
                    @empty
                        <div class="list-group-item text-center text-muted">
                            No conversations yet
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
