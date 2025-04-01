<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('/mainPage', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'links' => 'nullable|url'
        ]);

        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('images', 'public');
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed'], 400);
        }

        $post = Post::create([
            'title' => $request->caption, // ✅ Save caption as title
            'description' => $request->caption, // ✅ Save description (same as caption)
            'picture' => $imagePath, // ✅ Save image path
            'links' => $request->links // ✅ Save link if provided
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully!',
            'post' => $post
        ]);
    }



}

