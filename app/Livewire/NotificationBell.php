<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Livewire component: NotificationBell — shows recent notifications and unread count.
 */
class NotificationBell extends Component
{
    public bool $open = false;

    public function getNotifications()
    {
        return Auth::user()
            ->listifyNotifications()
            ->latest()
            ->take(8)
            ->get();
    }

    public function getUnreadCount()
    {
        return Auth::user()
            ->listifyNotifications()
            ->where('is_read', false)
            ->count();
    }

    public function markAllRead()
    {
        Auth::user()
            ->listifyNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function markRead(int $id)
    {
        $notif = \App\Models\Notification::where('user_id', Auth::id())
            ->findOrFail($id);
        $notif->update(['is_read' => true]);
    }

    public function render()
    {
        return view('livewire.notification-bell', [
            'notifications' => $this->getNotifications(),
            'unreadCount'   => $this->getUnreadCount(),
        ]);
    }
}
