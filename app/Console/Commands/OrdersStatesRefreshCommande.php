<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class OrdersStatesRefreshCommande extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-orders-states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        #Order::Save_orders();
        $orders = Order::orderBy('updated_at', 'asc')->get();
        foreach($orders as $order){
            if($order->State() != "Archived" && 
                $order->State() != "Doubled" && 
                $order->State() != "Canceled" && 
                $order->State() != "Failure" && 
                $order->State() != "Back ready" &&
                $order->State() != "Recovered" &&
                $order->State() != "Pending")
            {
                $order->Update_state();
            }
            if($order->State() == "Delivery"){
                $order->Get_information();
            }
            if($order->State() == "Pending" && $order->tracking != null){
                $order->Update_state();
            }
        }
    }
}

