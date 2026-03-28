<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, Notification $notification): RedirectResponse
    {
        abort_if($notification->user_id !== $request->user()->id, 403);

        $notification->update(['read' => true, 'read_at' => now()]);

        if ($notification->link) {
            return redirect($notification->link);
        }

        return back();
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        Notification::where('user_id', $request->user()->id)
            ->where('read', false)
            ->update(['read' => true, 'read_at' => now()]);

        return back();
    }

    public function clearAll(Request $request): RedirectResponse
    {
        Notification::where('user_id', $request->user()->id)->delete();

        return back();
    }
}
