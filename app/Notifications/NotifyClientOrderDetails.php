<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyClientOrderDetails extends Notification
{
    use Queueable;
    public $order;
    public $medicines;
    public $client;

    /**
     * Create a new notification instance.
     */
    public function __construct($order ,$medicines , $client)
    {
        $this->order =$order;
        $this->medicines =$medicines;
        $this->client = $client;
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
        $emptyArray=array();

        for($i = 0 ; $i<count($this->medicines);$i++) {
            $medicine= json_decode($this->medicines[$i], true);
            array_push($emptyArray,$medicine);
        }
        // dd($);
        foreach($emptyArray as $arr)
        {
            // dd($arr);
        }
        return (new MailMessage)
        //  ->action('Confirm Order', url('api/orders/confirmOrder/'.$this->order->id))
        // ->line('Order Details')
        // ->line('Order Total Price : '.$this->order['total_price'].'$')
        ->markdown('mail.orders.view',['order'=>$this->order,'medicines'=>$emptyArray , 'client'=>$this->client , 'confirmUrl'=>route("payments.checkout",["id"=>$this->order['id']]) , 'cancelUrl'=>route('orders.cancel',$this->order['id'])]);
    }
    // Route("payments.checkout",["id"=>$id])
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
