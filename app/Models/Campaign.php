<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = ["name", "slug", "daily_budget", "total_budget", "is_active", "changed_at", "started_at", "ended_at", "created_by"];
    
    public function Created_by():User
    {
        $user = User::where("id", $this->created_by)->first();
        if($user)return $user;
        return false;
    }
    public function Orders():Collection
    {
        $orders = Order::where("campaign", $this->id)->get();
        return $orders;
    }
    public function Delivered_orders():Collection
    {
        $orders = Order::where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('delivered_at', '<>', null)
                    ->orWhere('ready_at', '<>', null)
                    ->orWhere('recovered_at', '<>', null);
            })
            ->where('back_at', null)
            ->where('back_ready_at', null)
            ->where('campaign', $this->id);
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
            ->where('campaign', $this->id);
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
            ->where('campaign', $this->id);
        })->get();
        return $orders;
    }

    public function Total_orders_number():int
    {
        $orders = $this->Orders();
        return count($orders);
    }
    public function Total_orders_amount():float
    {
        $orders = $this->Orders();
        $amount = 0;
        foreach($orders as $order){
            $amount += $order->clean_price;
        }
        return $amount;
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
