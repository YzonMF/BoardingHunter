<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /** Marks one notification as read and opens the page it points to. */
    public function open(string $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $url = $notification->data['url'] ?? route('notifications.index');

        // Only follow links that stay on this site.
        if (!str_starts_with($url, url('/')) && !str_starts_with($url, '/')) {
            $url = route('notifications.index');
        }

        return redirect($url);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back();
    }
}
