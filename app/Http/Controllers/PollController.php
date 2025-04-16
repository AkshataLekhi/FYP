<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    public function vote(Request $request)
    {
        $request->validate([
            'poll_id' => 'required|exists:polls,id',
            'vote' => 'required|in:1,2'
        ]);

        $poll = Poll::with('post')->findOrFail($request->poll_id); // Load the post

        if ($request->vote == 1) {
            $poll->increment('votes_one');
        } elseif ($request->vote == 2) {
            $poll->increment('votes_two');
        }

        // Send notification to the post owner if it's not the voter
        $postOwnerId = $poll->post->user_id;

        if (Auth::id() !== $postOwnerId) {
            Notification::create([
                'user_id' => $postOwnerId,
                'post_id' => $poll->post_id,
                'type' => 'poll',
                'message' => Auth::user()->name . ' voted on your post'
            ]);
        }

        return back()->with('success', 'Thanks for voting!');
    }
}
