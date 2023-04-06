<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Js;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Parser\Php5;

class NotifyUserOrderDetails extends Notification implements ShouldQueue
{
    use Queueable;
    public $order;
    public $medicine;
    /**
     * Create a new notification instance.
     */
    public function __construct($order ,$medicine)
    {
        $this->order =$order;
        $this->medicine =$medicine;
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
        foreach($this->medicine as $med){
            $medicine2= json_decode($med, true);
            // ->link('order details')

            // dd($medicine);
        }
        return (new MailMessage)
                    ->line('Order Details')
                    ->line('Order Total Price : '.$this->order['total_price'].'$')
                  
                    // ->line('Medicine : '.$this->medicine)
                    ->action('Confirm order ', route('orders.show',$this->order['id']))
                    
                    ->line('Thank you for using our application!');
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
