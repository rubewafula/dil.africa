<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use  App\Product;

class VetProducts implements ShouldQueue
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
         
         $products= Product::where('publish_status',1)->get();

         foreach($products as $product)
         {
           // Check  if  a product  has  any  prices  set  

            if($product->prices->count() <  1)
            {
                $product->publish_status= 0;
                $product->save();
            }

         }

        //
    }
}
