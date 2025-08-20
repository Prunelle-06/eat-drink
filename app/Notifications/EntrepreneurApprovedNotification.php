<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EntrepreneurApprovedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private string $nom_complet,
        private string $nom_stand
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("{$this->nom_complet}, votre stand {$this->nom_stand} a été approuvé ! 🎉")
            ->line("Félicitations! {$this->nom_complet} votre demande d'inscription sur Taste&Stay a été approuvée par notre équipe.")
            ->line('Vous pouvez désormais :')
            ->line('✅Gérer vos produits : Ajoutez, modifiez ou supprimez vos offres depuis votre espace.')
            ->line('✅Recevoir des commandes : Les visiteurs peuvent réserver vos produits en ligne.')
            ->action('Accédez à votre dashboard', route('dashboard.entrepreneur'))
            ->line('Merci de nous faire confiance!');
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
}
