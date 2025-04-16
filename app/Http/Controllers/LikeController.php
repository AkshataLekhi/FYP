<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $user = Auth::user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->detach($user->id);
            $liked = false;
        } else {
            $post->likes()->attach($user->id);
            $liked = true;

            // Send notification to the post owner (avoid self-notification)
            if ($post->user_id != $user->id) {
                Notification::create([
                    'user_id' => $post->user_id, 
                    'post_id' => $post->id,
                    'type' => 'like',
                    'message' => Auth::user()->name . ' liked on "' . $post->title . '".'

                ]);
            }
        }

        $likeCount = $post->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likeCount' => $likeCount,
        ]);
    }
}
