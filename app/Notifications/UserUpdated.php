<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 * Class UserUpdated
 * @package App\Notifications
 */
class UserUpdated extends Notification
{
    use Queueable;

    private $user;

    /**
     * UserUpdated constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
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
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->buildMailMessage();
    }

    /**
     * @return MailMessage
     */
    protected function buildMailMessage()
    {
        return (new MailMessage)
            ->subject(Lang::get('Your information is updated!'))
            ->line(Lang::get('Your information is updated.'))
            ->line(Lang::get('Thank you for using our application!'));
    }
}
