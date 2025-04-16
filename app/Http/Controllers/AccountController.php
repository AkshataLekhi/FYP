<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class AccountController extends Controller
{


    public function index()
    {
        // $posts = Post::all();

        $posts = Auth::user()->posts;
        return view('myAccount', compact('posts'));
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
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('mainPage')->with('success', 'Post uploaded successfully!');
    }

    public function delete(Request $request)
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        Auth::logout();
        $user->delete();

        return redirect('/mainPage')->with('success', 'Your account has been deleted.');
    }


}
