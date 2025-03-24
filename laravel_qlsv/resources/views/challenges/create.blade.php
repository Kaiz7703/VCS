@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Create Challenge</div>
    <div class="card-body">
        <form action="{{ route('challenges.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="mb-3">
                <label for="hint" class="form-label">Hint</label>
                <textarea class="form-control" id="hint" name="hint" rows="3" required></textarea>
                <small class="form-text text-muted">
                    Provide a hint that will help students guess the filename (without extension)
                </small>
            </div>
            
            <div class="mb-3">
                <label for="file" class="form-label">Text File</label>
                <input type="file" class="form-control" id="file" name="file" accept=".txt" required>
                <small class="form-text text-muted">
                    Upload a .txt file. The filename (without extension) will be the answer.
                </small>
            </div>
            
            <button type="submit" class="btn btn-primary">Create Challenge</button>
        </form>
    </div>
</div>
@endsection
