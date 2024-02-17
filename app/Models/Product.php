<?php

namespace App\Models;

use App\Models\Order;
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
    
}
