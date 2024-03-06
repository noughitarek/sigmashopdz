<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Wilaya;
use App\Models\Commune;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        return ;
        $file = fopen("database/seeds/payed_orders.csv", "r");
        $header = fgetcsv($file);
        while (($row = fgetcsv($file)) !== false) {
            $rowData = array_combine($header, $row);
            unset($rowData['#']);
            $data[] = $rowData;
        }
        foreach($data as $order){
            $order['wilaya'] = Wilaya::where('name', $order['wilaya'])->first()->id;
            $order['commune'] = Commune::where('name', $order['commune'])->first()->id;
            
            $product = Product::where('slug', $order["product"])->first();
            if($product){
                $order['product'] = $product->id;
            }else{
                $product = Product::create(array(
                    "name" => $order["product"], 
                    "slug" => $order["product"], 
                    "price" => 0, 
                    "is_active" => false, 
                    "photos" => "unknown.jpg",
                    "created_by" => 1, 
                    "category" => 1
                ));
                $order['product'] = $product->id;
            }
            Order::create($order);
        }

        $backfile = fopen("database/seeds/back_orders.csv", "r");
        $backheader = fgetcsv($backfile);
        while (($backrow = fgetcsv($backfile)) !== false) {
            $backrowData = array_combine($backheader, $backrow);
            unset($backrowData['#']);
            $backdata[] = $backrowData;
        }
        foreach($backdata as $order){
            $order['wilaya'] = Wilaya::where('name', $order['wilaya'])->first()->id;
            $order['commune'] = Commune::where('name', $order['commune'])->first()->id;
            
            $product = Product::where('slug', $order["product"])->first();
            if($product){
                $order['product'] = $product->id;
            }else{
                $product = Product::create(array(
                    "name" => $order["product"], 
                    "slug" => $order["product"], 
                    "price" => 0, 
                    "is_active" => false, 
                    "photos" => "unknown.jpg",
                    "created_by" => 1, 
                    "category" => 1
                ));
                $order['product'] = $product->id;
            }
            Order::create($order);
        }



    }
}
