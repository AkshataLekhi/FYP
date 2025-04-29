<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StoryController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'media' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!$request->hasFile('media') || !$request->file('media')->isValid()) {
            return back()->with('error', 'Media upload failed.');
        }

        $path = $request->file('media')->store('stories', 'public');

        Story::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'picture' => $path,
            // 'expires_at' => now()->addHour(),
            'expires_at' => now()->addMinutes(10), //(expires in 10 minutes)

        ]);

        return back()->with('success', 'Story posted!');
    }

}
