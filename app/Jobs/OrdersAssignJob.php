<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrdersAssignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $newOrders=Order::where('status','New')->get();
        // dd($newOrders);
        $pharmacies=Pharmacy::all();
        foreach($newOrders as $order){
            $highestPriority= 0;
            foreach($pharmacies as $pharmacy){
                if($pharmacy->area_id==$order->address->area_id){
                    if($highestPriority<$pharmacy->priority){
                        $highestPriority= $pharmacy->priority; 
                        $order->update([ 
                            'status'=>'Processing',
                            'pharmacy_id'=> $pharmacy->id,
                            'doctor_id'=> $pharmacy->doctors->first()->id,
                        ]);
                    }
                }
            }
        }
        
    }
}
