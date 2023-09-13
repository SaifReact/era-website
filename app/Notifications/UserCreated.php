<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 * Class UserCreated
 * @package App\Notifications
 */
class UserCreated extends Notification
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
        $url = url(route('admin.login', [], false));

        return $this->buildMailMessage($url);
    }

    /**
     * @return MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Welcome to '.config('app.name').'!'))
            ->line(Lang::get('You are permitted to login at: '))
            ->action(Lang::get('Admin Control Panel'), $url)
            ->line(Lang::get('Your e-mail for login is: '. $this->user->email))
            ->line(Lang::get('However, please change your password by clicking forgot password immediately and then try to login with new password!'))
            ->line(Lang::get('Thank you for using our application!'));
    }
}
