<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\UpdateSesiSewaSpot;
use App\Models\SewaSpot;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SesiSpotUpdated extends Notification
{
    use Queueable;

    public $session;
    public $kodeBooking;

    /**
     * Create a new notification instance.
     */
    public function __construct(UpdateSesiSewaSpot $session, SewaSpot $sewaSpot)
    {
        $this->session = $session;
        $this->kodeBooking = $sewaSpot->kode_booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $adminWhatsAppNumber = '6289522956203'; // Ganti dengan nomor WhatsApp admin yang sebenarnya
        // $waLink = 'https://wa.me/' . $adminWhatsAppNumber . '?text=Halo%20Admin,%20saya%20ingin%20mengajukan%20perubahan%20untuk%20sesi%20sewa%20spot%20dengan%20ID%20' . $this->session->id;
        $waMessage = 'Halo Admin,%0A'
                . 'saya ingin mengajukan perubahan untuk sesi sewa spot dengan:%0A'
                . 'Kode Booking: ' . urlencode($this->kodeBooking) . '%0A'
                . 'Sesi: ' . urlencode($this->session->waktu_sesi) . '%0A'
                . 'Menjadi: (isi perubahan yang diajukan)';
        $waLink = 'https://wa.me/' . $adminWhatsAppNumber . '?text=' . $waMessage;
        return (new MailMessage)
                    ->subject('Sesi Spot Updated')
                    ->line('The session you booked has been updated.')
                    ->line('New Start Time: ' . $this->session->waktu_mulai)
                    ->line('New End Time: ' . $this->session->waktu_selesai)
                    ->action('Check Your Booking', url('/'))
                    ->line('If you would like to request changes, please contact the admin.')
                    ->action('Contact Admin via WhatsApp', $waLink)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'session_id' => $this->session->id,
            'start_time' => $this->session->waktu_mulai,
            'end_time' => $this->session->waktu_selesai,
            'kode_booking' => $this->kodeBooking,
        ];
    }
}
