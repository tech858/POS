<?php

namespace App\Notifications;

use App\Models\NotificationSetting;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationConfirmation extends BaseNotification
{
    
    protected $reservation;
    protected $notificationSetting;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->notificationSetting = NotificationSetting::where('type', 'reservation_confirmed')->where('restaurant_id', $reservation->branch->restaurant_id)->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if ($this->notificationSetting->send_email == 1 && $notifiable->email != '') {
            return ['mail'];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $build = parent::build($notifiable);
        return $build
            ->subject('Reservation Confirmation')
            ->greeting(__('app.hello') .' '. $notifiable->name . ',')
            ->line(__('email.reservation.text4'))
            ->line(__('email.reservation.text2'))
            ->line(__('modules.customer.name').': ' . $this->reservation->customer->name)
            ->line(__('app.date').': ' . $this->reservation->reservation_date_time->format('d M (l)'))
            ->line(__('app.time').': ' . $this->reservation->reservation_date_time->format('h:i A'))
            ->line(__('modules.reservation.guests') . ': ' . $this->reservation->party_size)
            ->action(__('email.reservation.action'), route('my_bookings', $this->reservation->branch->restaurant->hash));
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
