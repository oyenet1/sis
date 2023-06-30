<?php

namespace App\Notifications;

use App\Models\Clas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClassTeacherAssignmentNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $clas;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Clas $clas)
    {
        //
        $this->clas = $clas;
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
            'message' => 'Dear Teacher, this is to inform you that you have been assign to ' . $this->clas->school->short .  ' ' . $this->clas->name . $this->clas->high ?? $this->clas->section . ' as their Class Teacher',
        ];
    }
}