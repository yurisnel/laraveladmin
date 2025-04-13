<?php

namespace App\Notifications;

use App\Models\Access\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestActiveUser extends Notification 
{

    private User $user;
    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Solicitud de activación de cuenta')
            ->greeting('Hola!')
            ->line('El usuario ' . $this->user->full_name . ' ha solicitado activar su cuenta.')
            ->line('Recuerde cambiar su estado y asignarle un rol para poder activarlo!')
            ->action('Activar usuario',  route('users.edit', ['user' => $this->user->id]))
            ->line('Gracias por utilizar nuestra App!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function withDelay(object $notifiable): array
    {
        return [
            'mail' => now()->addMinutes(1),
            'sms' => now()->addMinutes(1),
        ];
    }
}
