<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow($id)
    {
        $user = Auth::user();
        $userToFollow = User::findOrFail($id);

        // Prevent user from following themselves
        // if ($user->id !== $userToFollow->id) {
        //     $user->followings()->syncWithoutDetaching([$userToFollow->id]);
        // }

        return back(); // or return response()->json([...]) for AJAX
    }
}
