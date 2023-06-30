<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Registration extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->greeting('Hello')
            ->line($this->user->first_name . ' ' . $this->user->last_name . ' has been added as ' . $this->user->roles[0]->name . ' in our school platform')
            ->line('Name: ' . $this->user->first_name . ' ' . $this->user->last_name)
            ->line('Email: ' . $this->user->email)
            ->line('Phone: ' . $this->user->phone)
            ->line('You can login to view the details of the created Users')
            ->action('Login Here', url('/login'));
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
            'name' => $this->user->first_name . ' ' . $this->user->last_name,
            'email' => $this->user->email,
            'id' => $this->user->id,
            'message' => $this->user->first_name . ' ' . $this->user->last_name . ' has been added as ' . $this->user->roles[0]->name . ' in our school platform',
        ];
    }
}