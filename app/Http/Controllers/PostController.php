<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('mainPage', compact('posts'));
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

    Post::create([
        'title' => $request->title,
        'description' => $request->description,
        'picture' => $imagePath,
    ]);

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


}
