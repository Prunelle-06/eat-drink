<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerContactNotification extends Notification
{
    use Queueable;

    protected $customer;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($customer, $message)
    {
        $this->customer = $customer;
        $this->message = $message;
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
            ->subject("Nouveau message d'un client")
            ->greeting("Bonjour {$notifiable->nom_complet},")
            ->line("Vous avez reçu un nouveau message concernant votre stand.")
            ->line("**De:** {$this->customer->nom_complet}")
            ->line("**Email:** {$this->customer->email}")
            ->line("**Message:**")
            ->line($this->message)
            // ->action('Répondre au client', route(''))
            ->line("Merci d'utiliser notre plateforme !");
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
