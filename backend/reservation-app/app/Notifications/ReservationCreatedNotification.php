<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reservation;

class ReservationCreatedNotification extends Notification 
{
    use Queueable;

    protected $reservation;

    /**
     * Bildirimde kullanılacak rezervasyon verisi.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Bildirimin hangi kanallar üzerinden gönderileceğini belirtir.
     */
    public function via($notifiable)
    {
        return ['mail'];  // E-posta kanalı üzerinden bildirim gönder
    }

    /**
     * Bildirimin e-posta içeriği.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Rezervasyon Onayı')
                    ->greeting('Merhaba ' . $notifiable->name . '!')
                    ->line('Rezervasyonunuz başarıyla oluşturuldu.')
                    ->line('Rezervasyon Detayları:')
                    ->line('Başlangıç Tarihi: ' . $this->reservation->start_date)
                    ->line('Bitiş Tarihi: ' . $this->reservation->end_date)
                    ->action('Rezervasyonlarımı Görüntüle', url("http://localhost:5173/reservation/" . $this->reservation->user_id

                    ))
                    ->line('Bizi tercih ettiğiniz için teşekkür ederiz!');
    }
}
