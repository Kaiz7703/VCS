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
                    @foreach($conversations as $conversationUser)
                        <a href="{{ route('messages.show', $conversationUser) }}" 
                           class="list-group-item list-group-item-action {{ $conversationUser->id === $user->id ? 'active' : '' }} d-flex align-items-center">
                            <i class="fas fa-user-circle fa-2x me-3"></i>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $conversationUser->name }}</h6>
                                    @if($conversationUser->unread_count > 0 && $conversationUser->id !== $user->id)
                                        <span class="badge bg-danger rounded-pill">{{ $conversationUser->unread_count }}</span>
                                    @endif
                                </div>
                                <small class="{{ $conversationUser->id === $user->id ? '' : 'text-muted' }}">
                                    {{ ucfirst($conversationUser->role->name) }}
                                </small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $user->name }}</h5>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: auto;">
                    @foreach($messages as $message)
                        <div class="mb-3 d-flex {{ $message->from_user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="card {{ $message->from_user_id === Auth::id() ? 'bg-primary text-white' : 'bg-light' }}" 
                                 style="max-width: 70%;">
                                <div class="card-body py-2 px-3">
                                    <p class="mb-1">{{ $message->content }}</p>
                                    <small class="{{ $message->from_user_id === Auth::id() ? 'text-white-50' : 'text-muted' }}">
                                        {{ $message->created_at->format('H:i') }}
                                    </small>
                                    @if($message->from_user_id === Auth::id())
                                        <form action="{{ route('messages.destroy', $message) }}" 
                                              method="POST" 
                                              class="d-inline float-end ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-sm text-white p-0">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form action="{{ route('messages.store', $user) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="content" class="form-control" placeholder="Type a message..." required>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
