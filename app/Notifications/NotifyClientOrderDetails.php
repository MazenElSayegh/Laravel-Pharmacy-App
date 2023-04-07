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
    public $medName;
    public $medQuantity;
    public $medPrice;
    public $client;
    public $pharmacyName;

    /**
     * Create a new notification instance.
     */
    public function __construct($order ,$medName,$medQuantity,$medPrice , $client ,$pharmacyName)
    {
        $this->order =$order;
        $this->medName =$medName;
        $this->medQuantity =$medQuantity;
        $this->medPrice =$medPrice;
        $this->client = $client;
        $this->pharmacyName = $pharmacyName;
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
        //  ->action('Confirm Order', url('api/orders/confirmOrder/'.$this->order->id))
        // ->line('Order Details')
        // ->line('Order Total Price : '.$this->order['total_price'].'$')
        ->markdown('mail.orders.view',['order'=>$this->order,'medName'=>$this->medName,'medQuantity'=>$this->medQuantity,'medPrice'=>$this->medPrice, 'client'=>$this->client,'pharmacyName'=>$this->pharmacyName , 'confirmUrl'=>route("payments.checkout",["id"=>$this->order['id']]) , 'cancelUrl'=>route('orders.cancel',$this->order['id'])]);
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
