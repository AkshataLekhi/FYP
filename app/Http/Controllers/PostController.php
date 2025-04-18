<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Poll;
use App\Models\Notification;
use App\Models\Story;
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

        $notifications = Notification::where('user_id', Auth::id())
                            ->latest()
                            ->take(10)
                            ->get();

        // ✅ Ensure this is BEFORE the return
        $stories = Story::where('expires_at', '>', now())->latest()->get();

        return view('mainPage', compact('posts', 'notifications', 'stories'));
    }



    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('picture')->store('images', 'public');

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'picture' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        if ($request->filled('option_one') && $request->filled('option_two')) {
            Poll::create([
                'post_id' => $post->id,
                'option_one' => $request->option_one,
                'option_two' => $request->option_two,
            ]);
        }

        return redirect()->route('mainPage')->with('success', 'Post uploaded successfully!');
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
            'user_id' => Auth::id(),
            'expires_at' => now()->addHours($request->duration),
        ]);

        return redirect()->back()->with('success', 'Temporary post created!');
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['success' => true]);
    }

    public function followUser(Request $request)
{
    $userIdToFollow = $request->input('user_id');
    $user = Auth::user();

    // Check if the user is trying to follow themselves
    if ($user->id == $userIdToFollow) {
        return response()->json(['success' => false, 'message' => 'You cannot follow yourself.']);
    }

    // Check if the user is already following the target user
    if ($user->followings()->where('followed_user_id', $userIdToFollow)->exists()) {
        return response()->json(['success' => false, 'message' => 'Already following.']);
    }

    // Attach the user to the following list
    $user->followings()->attach($userIdToFollow);

    return response()->json(['success' => true, 'message' => 'Now following.']);
}

}
