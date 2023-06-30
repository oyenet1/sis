<?php

namespace App\Notifications;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserLeaveNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $leave;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'We wish to inform that your leave application has been submitted, you will be notified when the leave is approve or not'
        ];
    }
}