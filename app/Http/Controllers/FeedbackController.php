<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // ✅ This line is required

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
