<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function landingPage()
    {
        $allPosts=Post::all();
        return view('landingPage');
        // return view('landingPage', compact('allPosts'));
    }

    public function index()
    {
        $posts = Post::latest()->get(); // Fetch all posts (latest first)
        return view('main', compact('posts')); // Pass $posts to the view
    }

    /**
     * Store a new post in the database.
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'links' => 'nullable|url',
            'pin_size' => 'required|in:small,medium,large',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('uploads/posts', $imageName, 'public');
        } else {
            $path = null;
        }

        // Store post in database
        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'links' => $request->input('links'),
            'picture' => $path, // Store image path
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }


    public function main()
    {
        return view('main');
    }

    public function profile()
    {
        if(session()->has('id'))
        {
            $user=User::find(session()->get('id'));

            return view('profile', compact(('user')));
        }
        return redirect(('login'));
    }

    public function signup()
    {
        return view('signup');
    }

    public function login()
    {
        return view('login');
    }

    public function logout()
    {
        session()->forget('id');
        return redirect('/landingPage');
    }

    public function loginUser(Request $data)
    {
        // Retrieve user by email.
        $user = User::where('email', $data->input('email'))->first();

        // Verify that the user exists and the password matches.
        if ($user && Hash::check($data->input('password'), $user->password)) {
            session()->put('id', $user->id);
            session()->put('type', $user->type);

            // Redirect based on user type.
            if ($user->type == 'Member') {
                return redirect('mainPage');
            }
            return redirect('mainPage');
        } else {
            return redirect('login')->with('error', 'Email/Password Incorrect');
        }
    }

    public function signupUser(Request $data)
    {
        $newUser = new User();
        $newUser->fullname = $data->input('fullname');
        $newUser->email = $data->input('email');
        $newUser->number = $data->input('number');
        // Hash the password before saving.
        $newUser->password = bcrypt($data->input('password'));

        if ($data->hasFile('file')) {
            $file = $data->file('file');
            $newUser->picture = $file->getClientOriginalName();
            // Save the file to a public folder.
            $file->move(public_path('uploads/profiles/'), $newUser->picture);
        } else {
            // Use a default picture if none is uploaded.
            $newUser->picture = 'default.png';
        }

        $newUser->type = 'Member';

        if ($newUser->save()) {
            return redirect('login')->with('success', 'Your Account Is Ready.');
        }

        return redirect()->back()->with('error', 'Signup failed.');
    }

    public function updateUser(Request $data)
    {
        $user = User::find(session()->get('id'));
        $user->fullname = $data->input('fullname');
        $user->password = bcrypt($data->input('password'));

        if ($data->hasFile('file')) {
            $file = $data->file('file');
            $user->picture = $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles/'), $user->picture);
        } else {
            // Use a default picture if none is uploaded.
            $user->picture = 'default.png';
        }

        $user->type = 'Member';

        if ($user->save()) {
            return redirect()->back()->with('success', 'Your Account Is Updated.');
        }

        return redirect()->back()->with('error', 'Signup failed.');
    }
}
