<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'deleted_by',
        'description',
        'is_active'
    ];
    public function Created_by():User
    {
        $user = User::where("id", $this->created_by)->first();
        if($user)return $user;
        return false;
    }
    public function Products()
    {
        $products = Product::where("category", $this->id)->where("is_active", true)->get();
        return $products;
    }
    public function Orders()
    {
        $products = $this->Products();
        $orders = collect([]);
        foreach($products as $product){
            $orders = $orders->merge($product->Orders());
        }
        return $orders;
    }
    public function Total_orders_number()
    {
        return count($this->Orders());
    }
    public function Total_orders_amount()
    {
        $orders = $this->Orders();
        $amount = 0;
        foreach($orders as $order){
            $amount += $order->clean_price;
        }
        return $amount;
    }
    public function Delivered_orders()
    {
        $products = $this->Products();
        $orders = collect([]);
        foreach($products as $product){
            $orders = $orders->merge($product->Delivered_orders());
        }
        return $orders;
    }
    public function Total_delivered_orders_number():int
    {
        $orders = $this->Delivered_orders();
        return count($orders);
    }
    public function Total_delivered_orders_amount():float
    {
        $orders = $this->Delivered_orders();
        $amount = 0;
        foreach($orders as $order){
            $amount += $order->clean_price;
        }
        return $amount;
    }
    public function Delivery_orders()
    {
        $products = $this->Products();
        $orders = collect([]);
        foreach($products as $product){
            $orders = $orders->merge($product->Delivery_orders());
        }
        return $orders;
    }
    public function Total_delivery_orders_number():int
    {
        $orders = $this->Delivery_orders();
        return count($orders);
    }
    public function Total_delivery_orders_amount():float
    {
        $orders = $this->Delivery_orders();
        $amount = 0;
        foreach($orders as $order){
            $amount += $order->clean_price;
        }
        return $amount;
    }
    public function Back_orders()
    {
        $products = $this->Products();
        $orders = collect([]);
        foreach($products as $product){
            $orders = $orders->merge($product->Back_orders());
        }
        return $orders;
    }
    public function Total_back_orders_number():int
    {
        $orders = $this->Back_orders();
        return count($orders);
    }
    public function Total_back_orders_amount():float
    {
        $orders = $this->Back_orders();
        $amount = 0;
        foreach($orders as $order){
            $amount += $order->clean_price;
        }
        return $amount;
    }
}
