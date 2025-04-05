<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Rating;

class RatingController extends Controller
{
    public function add(Request $request)
    {
        $stars = $request->input('product_rating');
        $post_id = $request->input('post_id');

        $post_check = Post::where('id', $post_id)->first();

        if ($post_check) {
            Rating::create([
                'post_id' => $post_id,
                'stars' => $stars
            ]);

            return redirect()->back()->with('success', 'Thanks for rating!');
        } else {
            return redirect()->back()->with('error', 'Invalid post selected for rating.');
        }
    }

    public function store(Request $request)
    {
        // Optional: another rating method if needed
    }
}
