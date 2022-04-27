<?php

namespace App\Notifications;

use App\Fleet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyChat extends Notification
{
    use Queueable;
    public $fleet_name;
    public $fleet_id;
    public $chat;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $chat)
    {
        $fleet = Fleet::find($user_id);
        $this->fleet_name = $fleet->name;
        $this->fleet_id = $fleet->uuid;
        $this->chat = $chat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {

        return [
            'fleet_name' => $this->fleet_name,
            'chat' => $this->chat,
            'url' => '/#/fleets/' . $this->fleet_id . '/chat',
            'description_en' => 'Sent Maessage',
            'description_ar' => 'أرسل لك رسالة '
        ];
    }

    public function toBroadcast($notifiable)
    {


        return [
            'data' => [
                'fleet_name' => $this->fleet_name,
                'chat' => $this->chat,
                'url' => '/#/fleets/' . $this->fleet_id . '/chat',
                'description_en' => 'Sent Maessage',
                'description_ar' => 'أرسل لك رسالة '
            ]

        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
