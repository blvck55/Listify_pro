<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationBell extends Component
{
    public bool $open = false;

    public function getNotifications()
    {
        return auth()->user()
            ->listifyNotifications()
            ->latest()
            ->take(8)
            ->get();
    }

    public function getUnreadCount()
    {
        return auth()->user()
            ->listifyNotifications()
            ->where('is_read', false)
            ->count();
    }

    public function markAllRead()
    {
        auth()->user()
            ->listifyNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function markRead(int $id)
    {
        $notif = \App\Models\Notification::where('user_id', auth()->id())
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
