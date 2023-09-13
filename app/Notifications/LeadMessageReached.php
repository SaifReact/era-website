<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class LeadMessageReached extends Notification
{
    use Queueable;

    /** @var  */
    private $leadContent = [];

    /**
     * LeadMessageReached constructor.
     * @param array $leadContent
     */
    public function __construct(array $leadContent)
    {
        $this->leadContent = $leadContent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject(Lang::get("A new message sent from website contact form!"))
            ->level('info')
            ->greeting(Lang::get('Greetings!'))
            ->line($this->leadContent['name'].' '.Lang::get('Email Content').' '.Lang::get('sent you a message: '))
            ->line(Lang::get('Subject: ').$this->leadContent['subject'])
            ->line(Lang::get('Message: '). $this->leadContent['message'])
            ->line(Lang::get('Thank you for using our application!'));
    }
}
