<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function vote(Request $request)
    {
        $request->validate([
            'poll_id' => 'required|exists:polls,id',
            'vote' => 'required|in:1,2'
        ]);

        $poll = Poll::findOrFail($request->poll_id);

        if ($request->vote == 1) {
            $poll->increment('votes_one');
        } elseif ($request->vote == 2) {
            $poll->increment('votes_two');
        }

        return back()->with('success', 'Thanks for voting!');
    }

}
