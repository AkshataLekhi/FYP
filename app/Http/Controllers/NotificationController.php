<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Get all notifications for the logged-in user
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                            ->latest()
                            ->take(10)
                            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // Mark all as read
    public function markAsRead()
    {
        Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }

    
}
