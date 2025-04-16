<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Poll;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PostController extends Controller
{
    public function index(Request $request)
{
    $query = Post::with('poll', 'comments', 'likes');

    if ($request->has('search') && !empty($request->search)) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $posts = $query->get();

    // 👇 Add this to fetch notifications for the logged-in user
    $notifications = Notification::where('user_id', Auth::id())
                        ->latest()
                        ->take(10)
                        ->get();

    // 👇 Pass $notifications to the view
    return view('mainPage', compact('posts', 'notifications'));
}

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('picture')->store('images', 'public');

        // Create post with logged-in user ID
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'picture' => $imagePath,
            'user_id' => Auth::id(), // make sure user is logged in
        ]);

        // Optional Poll creation if both options are filled
        if ($request->filled('option_one') && $request->filled('option_two')) {
            Poll::create([
                'post_id' => $post->id,
                'option_one' => $request->option_one,
                'option_two' => $request->option_two,
            ]);
        }

        return redirect()->route('mainPage')->with('success', 'Post uploaded successfully!');
    }


    public function update(Request $request, $id)
    {
    $post = Post::findOrFail($id);

    // Optional: You can add validation
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $post->title = $request->title;
    $post->description = $request->description;
    $post->save();

    return redirect()->back()->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = \App\Models\Post::findOrFail($id);
        $post->delete();

        return response()->json(['success' => true]);
    }

    public function storeTemporary(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'duration' => 'required|in:1,24',
    ]);

    $imagePath = $request->file('picture')->store('images', 'public');

    Post::create([
        'title' => $request->title,
        'description' => $request->description,
        'picture' => $imagePath,
        'expires_at' => now()->addHours($request->duration),
    ]);

    return redirect()->back()->with('success', 'Temporary post created!');
}

}
