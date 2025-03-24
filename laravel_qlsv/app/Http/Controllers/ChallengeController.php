<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::orderBy('created_at', 'desc')->get();
        return view('challenges.index', compact('challenges'));
    }

    public function create()
    {
        if (!Auth::user()->isTeacher()) {
            abort(403);
        }
        return view('challenges.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isTeacher()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'hint' => 'required|string',
            'file' => 'required|file|mimes:txt|max:1024'
        ]);

        // Store the original filename without extension as the answer
        $originalName = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
        
        // Store file with original name to maintain the answer
        $path = $request->file('file')->storeAs('challenges', $originalName . '.txt');

        Challenge::create([
            'title' => $validated['title'],
            'hint' => $validated['hint'],
            'file_path' => $path,
            'teacher_id' => Auth::id()
        ]);

        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully');
    }

    public function show(Challenge $challenge)
    {
        return view('challenges.show', compact('challenge'));
    }

    public function attempt(Request $request, Challenge $challenge)
    {
        if (!Auth::user()->isStudent()) {
            abort(403);
        }

        $answer = $request->input('answer');
        
        // Get filename without path and extension
        $filename = pathinfo($challenge->file_path, PATHINFO_FILENAME);

        // Clean up input and filename for comparison
        $cleanAnswer = trim(strtolower($answer));
        $cleanFilename = trim(strtolower($filename));
        
        // Log for debugging
        \Log::info('Clean Answer: ' . $cleanAnswer);
        \Log::info('Clean Filename: ' . $cleanFilename);
        \Log::info('Original file_path: ' . $challenge->file_path);

        if ($cleanAnswer === $cleanFilename) {
            $content = Storage::get($challenge->file_path);
            return back()->with('content', $content)
                        ->with('success', 'Correct answer!');
        }

        return back()->with('error', 'Incorrect answer, try again!')
                    ->withInput();
    }
}
