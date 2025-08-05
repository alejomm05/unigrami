<?php

namespace App\Http\Controllers;

use App\Models\Mention;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->get();

        return view('notifications.index', ['notifications' => $notifications]);
    }

    public function markAsRead(Request $request): JsonResponse
    {
        $request->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function mentions(Request $request): View
    {
        $mentions = $request->user()
            ->mentions()
            ->with('mentionable')
            ->latest()
            ->get();

        return view('notifications.mentions', compact('mentions'));
    }
}
