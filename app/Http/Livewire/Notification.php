<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notification extends Component
{

    // mark a single notification as read
    function readOne($id)
    {
        dd('i am clicked');
        $read =  currentUser()->unreadNotifications->where('id', $id);
        dd($read);
    }

    // mark all notifications as read
    function readAll()
    {
        dd('hi');
        currentUser()->unreadNotifications->markAsRead();
    }
    // mark all notifications as read
    function readSingle($id)
    {
        dd($id);
        // currentUser()->unreadNotifications->markAsRead();
    }
    public function render()
    {
        $unread = currentUser()->unreadNotifications;
        $read = currentUser()->readNotifications;
        return view('livewire.notification', compact(['unread', 'read']));
    }
}