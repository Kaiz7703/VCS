<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::orderBy('created_at', 'desc')->get();
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        if (!Auth::user()->isTeacher()) {
            abort(403);
        }
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isTeacher()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240'
        ]);

        $path = $request->file('file')->store('assignments');

        Assignment::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path,
            'teacher_id' => Auth::id()
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully');
    }

    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        if (!Auth::user()->isStudent()) {
            abort(403);
        }

        $validated = $request->validate([
            'file' => 'required|file|max:10240'
        ]);

        $path = $request->file('file')->store('submissions');

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => Auth::id(),
            'file_path' => $path
        ]);

        return back()->with('success', 'Assignment submitted successfully');
    }
}
