<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dashboard extends Model
{
    use HasFactory;

    public static function months()
    {
        $firstOrderDate = Carbon::parse(Order::where('delivered_at', "!=", null)->orderBy('delivered_at', 'asc')->first()->delivered_at);
        return self::generateMonthList($firstOrderDate);
    }

    public static function changes($new, $old)
    {
        if($old != 0)return (int)(($new-$old)/$old*100);
        else return 0;
    }

    public static function Products($timestamp)
    {
        if(!isset($timestamp['end_timestamp'])){
            $timestamp['end_timestamp'] = Carbon::createFromTimestamp($timestamp['start_timestamp'])->endOfMonth()->timestamp;
        }
        $products = [];
        foreach(Product::all() as $product)
        {
            $orders = Order::whereBetween('delivered_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])->where('product', $product->id)->count();
            $activities = Activity::whereBetween('created_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])->where("url", "LIKE", "%".$product->slug."%")->count();
            $revenue = Order::whereBetween('delivered_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])->where('product', $product->id)->sum('clean_price');
            $income = Order::whereBetween('delivered_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])->where('product', $product->id)->sum('clean_price') - Payement::whereBetween('created_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])->where('description', 'like', '%'.$product->slug.'%')->sum('amount');
            $products[] = array(
                'name' => $product->name,
                'photo' => asset('/img/products/'.explode(',', $product->photos)[0]),
                'category' => $product->Category()->name,
                'orders' => $orders,
                'activities' => $activities,
                'orderPerActivity' => $activities!=0?(int)($orders/$activities*100):'n/a',
                'revenue' => $revenue,
                'income' => $income,
            );
        }
        return $products;
    }

    public static function getRevenue($timestamp)
    {
        if(!isset($timestamp['end_timestamp'])){
            $timestamp['end_timestamp'] = Carbon::createFromTimestamp($timestamp['start_timestamp'])->endOfMonth()->timestamp;
        }
        return Order::
            whereBetween('delivered_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])
            ->sum('clean_price');
    }

    public static function getIncome($timestamp)
    {
        if(!isset($timestamp['end_timestamp'])){
            $timestamp['end_timestamp'] = Carbon::createFromTimestamp($timestamp['start_timestamp'])->endOfMonth()->timestamp;
        }
        return Order::
            whereBetween('delivered_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])
            ->sum('clean_price')-
            Payement::whereBetween('created_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])
            ->sum('amount');
    }

    public static function getOrders($timestamp)
    {
        if(!isset($timestamp['end_timestamp'])){
            $timestamp['end_timestamp'] = Carbon::createFromTimestamp($timestamp['start_timestamp'])->endOfMonth()->timestamp;
        }
        return Order::
            whereBetween('delivered_at', [Carbon::createFromTimestamp($timestamp['start_timestamp']), Carbon::createFromTimestamp($timestamp['end_timestamp'])])
            ->count();
    }

    private static function generateMonthList(Carbon $startDate)
    {
        $begining = $startDate->timestamp;
        $endDate = Carbon::now()->startOfMonth()->timestamp;
        $months = [];
        $currentDate = $startDate->startOfMonth();
        
        while ($endDate >= $currentDate->timestamp) {
            $months[] = [
                'start_timestamp' => $currentDate->startOfMonth()->timestamp,
                'formatted' => $currentDate->format('F Y'),
            ];
            $currentDate = $currentDate->addMonth();
        }
        $months[] = [
            'start_timestamp' => $begining,
            'end_timestamp' => Carbon::now()->timestamp,
            'formatted' => 'All times',
        ];
        return $months;
    }
}
