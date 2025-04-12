<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
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
        }

        $likeCount = $post->likes()->count();

        return response()->json([
            'liked' => $liked,
            'likeCount' => $likeCount,
        ]);
    }
}

