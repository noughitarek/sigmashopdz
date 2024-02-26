<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Stock;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'price',
        'old_price',
        'photos',
        'videos',
        'is_active',
        'description',
        'created_by',
        'category'
    ];

    
    public function Created_by():User
    {
        $user = User::where("id", $this->created_by)->first();
        if($user)return $user;
        return false;
    }
    
    public function Category():Category
    {
        $category = Category::where("id", $this->category)->first();
        if($category)return $category;
        return false;
    }
    
    public function Spend():float
    {
        $campaigns = Campaign::where('product', $this->id)->get();
        $total = 0;
        foreach($campaigns as $campaign){
            $total += $campaign->total_budget;
        }
        return $total;
    }
    public function Reduction()
    {
        $res = 0;
        if ($this->old_price != 0) {
            $res = (int)(($this->old_price-$this->price)/$this->old_price*100);
        }
        return $res;
        
    }
    public function Orders():?Collection
    {
        $orders = Order::where("product", $this->id)
        ->where('failure_at', null)
        ->where('canceled_at', null)
        ->get();
        if($orders)return $orders;
        return new Order();
    }
    
    public function Delivered_orders():?Collection
    {
        
        $orders = Order::where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('delivered_at', '<>', null)
                    ->orWhere('ready_at', '<>', null)
                    ->orWhere('recovered_at', '<>', null);
            })
            ->where('back_at', null)
            ->where('back_ready_at', null)
            ->where('failure_at', null)
            ->where('canceled_at', null)
            ->where('product', $this->id);
        })
        ->get();
        return $orders;
    }

    public function Delivery_orders():?Collection
    {
        
        $orders = Order::where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('shipped_at', '<>', null)
                    ->orWhere('validated_at', '<>', null)
                    ->orWhere('delivery_at', '<>', null);
            })
            ->where('delivered_at', null)
            ->where('ready_at', null)
            ->where('recovered_at', null)
            ->where('back_at', null)
            ->where('back_ready_at', null)
            ->where('failure_at', null)
            ->where('canceled_at', null)
            ->where('product', $this->id);
        })->get();
        return $orders;
    }

    public function Back_orders():?Collection
    {
        
        $orders = Order::where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('back_at', '<>', null)
                         ->orWhere('back_ready_at', '<>', null);
            })
            ->where('failure_at', null)
            ->where('canceled_at', null)
            ->where('product', $this->id);
        })->get();
        return $orders;
    }
    
    public function Orders_amount():?float
    {
        $orders = $this->Orders();
        $total = 0;
        foreach($orders as $order){
            $total += $order->clean_price;
        }
        return $total;
    }
    
    public function Delivered_orders_amount():?float
    {
        $orders = $this->Delivered_orders();
        $total = 0;
        foreach($orders as $order){
            $total += $order->clean_price;
        }
        return $total;
    }
    
    public function Delivery_orders_amount():?float
    {
        $orders = $this->Delivery_orders();
        $total = 0;
        foreach($orders as $order){
            $total += $order->clean_price;
        }
        return $total;
    }
    
    public function Back_orders_amount():?float
    {
        $orders = $this->Back_orders();
        $total = 0;
        foreach($orders as $order){
            $total += $order->clean_price;
        }
        return $total;
    }
    
    public function Stock():?int
    {
        $restock = Stock::where('product', $this->id)->get();
        $stock = 0;
        foreach($restock as $order){
            $stock += $order->quantity;
        }
        foreach($this->Delivery_orders() as $order){
            $stock -= $order->quantity;
        }
        foreach($this->Delivered_orders() as $order){
            $stock -= $order->quantity;
        }
        foreach($this->Back_orders() as $order){
            $stock += $order->quantity;
        }
        return $stock;
    }
}
