<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class CleanDatabaseCommande extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean-database';

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
        $orders = Order::all();
        foreach($orders as $order){
            $order->delivery_price = $order->Wilaya()->real_price;
            $order->clean_price = $order->total_price - $order->Wilaya()->real_price;
            $order->save();
        }
    }
}
