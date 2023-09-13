<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class UserPasswordChanged extends Notification
{
    use Queueable;

    private $user;

    /**
     * UserCreated constructor.
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
            ->subject(Lang::get('Your password is changed!'))
            ->line(Lang::get('Your password is changed by you or some other admin(May be for some reason?).'))
            ->line(Lang::get('If you change the password, you can login with new password. However, if any other
            admin changed your password, you should reset your password immediately by clicking on forgot password from
            admin login window. After changing the password, you can then login to the system!'))
            ->line(Lang::get('Thank you for using our application!'));
    }
}
