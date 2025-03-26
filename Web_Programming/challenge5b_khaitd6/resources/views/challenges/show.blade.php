@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Challenge Details</div>
    <div class="card-body">
        <h4>{{ $challenge->title }}</h4>
        <p class="text-muted">Created by: {{ $challenge->teacher->name }}</p>
        
        <div class="card mb-4">
            <div class="card-header">Hint</div>
            <div class="card-body">
                <p>{{ $challenge->hint }}</p>
            </div>
        </div>

        @if(Auth::user()->isStudent())
            <div class="card">
                <div class="card-header">Try to solve it!</div>
                <div class="card-body">
                    <form action="{{ route('challenges.attempt', $challenge) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="answer" class="form-label">Your Answer</label>
                            <input type="text" class="form-control" id="answer" name="answer" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Answer</button>
                    </form>

                    @if(session('content'))
                        <div class="mt-4">
                            <h5>Congratulations! Here's the content:</h5>
                            <div class="border p-3 mt-2">
                                {!! nl2br(e(session('content'))) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
