<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class VerifyEmailCustom extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        return (new MailMessage)
            ->subject('Verifikasi Email Akun AnimeList')
            ->greeting('Halo 👋')
            ->line('Terima kasih sudah mendaftar di AnimeList.')
            ->line('Klik tombol di bawah untuk verifikasi email kamu.')
            ->action('Verifikasi Email', $url)
            ->line('Jika kamu tidak merasa mendaftar, abaikan email ini.');
    }
}
