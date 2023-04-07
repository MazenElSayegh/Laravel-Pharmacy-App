<?php

namespace App\Console\Commands;
use Illuminate\Support\Carbon;
use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Console\Command;

class NewToProcessingOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requests:processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes the Requests which has been in new status for a period of time to processing status.';

    /**
     * Execute the console command.
     */
    public function handle(){
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
        info('every_minute');

    }
}
