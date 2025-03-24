@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Assignment Details</div>
    <div class="card-body">
        <h4>{{ $assignment->title }}</h4>
        <p class="text-muted">Posted by: {{ $assignment->teacher->name }}</p>
        <p>{{ $assignment->description }}</p>
        
        <div class="mb-4">
            <h5>Assignment File</h5>
            <a href="{{ Storage::url($assignment->file_path) }}" class="btn btn-primary" download>
                Download Assignment
            </a>
        </div>

        @if(Auth::user()->isStudent())
            <div class="card mt-4">
                <div class="card-header">Submit Assignment</div>
                <div class="card-body">
                    <form action="{{ route('assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload your work</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        @endif

        @if(Auth::user()->isTeacher())
            <div class="card mt-4">
                <div class="card-header">Submissions</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Submitted At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignment->submissions as $submission)
                                <tr>
                                    <td>{{ $submission->student->name }}</td>
                                    <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ Storage::url($submission->file_path) }}" class="btn btn-sm btn-info" download>
                                            Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
