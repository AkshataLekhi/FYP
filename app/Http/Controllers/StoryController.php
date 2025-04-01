<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;


class StoryController extends Controller
{
    // Fetch active stories
    public function index()
    {
        $stories = Story::active()->with('user')->get();
        return response()->json($stories);
    }

    // Store a new story
    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpeg,png,jpg,mp4|max:10240',
            'media_type' => 'required|in:image,video',
        ]);

        $path = $request->file('media')->store('stories', 'public');

        $story = Story::create([
            'user_id' => auth()->id(),
            'media_path' => $path,
            'media_type' => $request->media_type,
        ]);

        return response()->json(['message' => 'Story posted successfully', 'story' => $story]);
    }
}

