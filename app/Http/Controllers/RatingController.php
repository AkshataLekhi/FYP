<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;


class RatingController extends Controller
{
    public function add(Request $request)
{
    $stars = $request->input('product_rating');
    $post_id = $request->input('post_id');

    $post = Post::find($post_id);

    if ($post) {
        Rating::create([
            'post_id' => $post_id,
            'stars' => $stars
        ]);

        // Send notification to post owner (not self)
        if (Auth::check() && Auth::id() !== $post->user_id) {
            Notification::create([
                'user_id' => $post->user_id,
                'post_id' => $post->id,
                'type' => 'rating',
                'message' => Auth::user()->name . ' rated on "' . $post->title . '".'


            ]);
        }

        return redirect()->back()->with('success', 'Thanks for rating!');
    } else {
        return redirect()->back()->with('error', 'Invalid post selected for rating.');
    }
}

}
