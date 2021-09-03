<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use  App\Order;
use  App\Order_detail;
use  App\User;
use  App\Seller_order;


class ProcessSellerOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders= Order::where('job_processed',0)->orWhere('job_processed',NULL)->get();

        foreach($orders  as $order)
        {

             foreach($order->order_details as $detail)
             {
                 $delivery_date = $order->created_at;
             //    $delivery_date=  $delivery_date->addDays(1);

                // echo $order->created_at;
                //exit;

                Seller_order::create([
                    'seller_id'=>$detail->product->seller_id,
                    'order_detail_id'=>$detail->id,
                    'order_id'=>$order->id,
                    'order_date'=>$detail->created_at,
                    'shipping_status'=>1,
                    'delivery_due_date'=>$detail->created_at,
                    'order_status'=>'ACCEPTED',
                    'order_reference'=>$order->order_reference

                ]);

                exit;

             }
        }
        //
    }
}
