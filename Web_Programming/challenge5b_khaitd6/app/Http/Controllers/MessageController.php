<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        // Get all conversations with unread count
        $conversations = Message::where('from_user_id', Auth::id())
            ->orWhere('to_user_id', Auth::id())
            ->select('from_user_id', 'to_user_id')
            ->groupBy('from_user_id', 'to_user_id')
            ->get()
            ->map(function ($message) {
                $otherUserId = $message->from_user_id === Auth::id() 
                    ? $message->to_user_id 
                    : $message->from_user_id;
                $user = User::find($otherUserId);
                $user->unread_count = Message::where('from_user_id', $otherUserId)
                    ->where('to_user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
                return $user;
            })->unique();

        return view('messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        // Get conversations list like in index method
        $conversations = Message::where('from_user_id', Auth::id())
            ->orWhere('to_user_id', Auth::id())
            ->select('from_user_id', 'to_user_id')
            ->groupBy('from_user_id', 'to_user_id')
            ->get()
            ->map(function ($message) {
                $otherUserId = $message->from_user_id === Auth::id() 
                    ? $message->to_user_id 
                    : $message->from_user_id;
                $user = User::find($otherUserId);
                $user->unread_count = Message::where('from_user_id', $otherUserId)
                    ->where('to_user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
                return $user;
            })->unique();

        // Get messages for current conversation
        $messages = Message::where(function($query) use ($user) {
                $query->where('from_user_id', Auth::id())
                      ->where('to_user_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('from_user_id', $user->id)
                      ->where('to_user_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('from_user_id', $user->id)
            ->where('to_user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('messages', 'user', 'conversations'));
    }

    public function store(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot send messages to yourself');
        }

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $message = Message::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $user->id,
            'content' => $validated['content']
        ]);

        $user->notify(new NewMessage($message));
        return back()->with('success', 'Message sent successfully');
    }

    public function update(Request $request, Message $message)
    {
        if ($message->from_user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $message->update($validated);
        return back()->with('success', 'Message updated successfully');
    }

    public function destroy(Message $message)
    {
        if ($message->from_user_id !== Auth::id()) {
            abort(403, 'You can only delete your own messages');
        }

        $message->delete();
        return back()->with('success', 'Message deleted successfully');
    }

    public function markAsRead($id)
    {
        Auth::user()
            ->unreadNotifications
            ->when($id, function($query) use ($id) {
                return $query->where('id', $id);
            })
            ->markAsRead();

        return response()->noContent();
    }
}
