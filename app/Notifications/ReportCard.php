<?php

namespace App\Notifications;

use App\Models\Guardian;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReportCard extends Notification implements ShouldQueue
{
    public $guardian;
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Guardian $guardian)
    {
        $this->guardian = $guardian;
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
            ->subject('Report Card '. config('app.name'))
            ->view('emails.reports', ['guardian'=> $this->guardian]);
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
            'message' => 'We wish to inform you that the result of this ' . currentTerm() . ' is ready, you should check and print your children reportcard',
        ];
    }
}