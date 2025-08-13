<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notification marquée comme lue.');
    }
}
