<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Send notification to the post owner (avoid self-notification)
        $post = Post::find($request->post_id);
        if ($post->user_id != Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id, // receiver
                'post_id' => $post->id,
                'type' => 'comment',
                'message' => Auth::user()->name . ' commented on "' . $post->title . '".'
            ]);
        }

        return back()->with('success', 'Comment added!');
    }
}
