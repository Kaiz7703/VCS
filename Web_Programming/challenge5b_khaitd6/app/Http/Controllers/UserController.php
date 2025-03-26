<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!Auth::user()->isTeacher() && Auth::id() !== $user->id) {
            abort(403);
        }
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isTeacher() && Auth::id() !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed'
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('users.show', $user)->with('success', 'Profile updated successfully');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isTeacher()) {
            abort(403);
        }
        
        if ($user->isTeacher()) {
            return back()->with('error', 'Cannot delete teacher accounts');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
