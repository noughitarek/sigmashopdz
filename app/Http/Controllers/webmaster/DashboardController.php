<?php

namespace App\Http\Controllers\webmaster;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Activity;
use App\Models\Payement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data["title"] = 'Dashboard';
        
        $data["lastMonthRevenue"] = Order::
        where('delivered_at', '>', Carbon::now()
        ->subMonth())->sum('clean_price');

        $data["lastMonthOrders"] = Order::
        where('delivered_at', '>', Carbon::now()->subMonth())
        ->count();

        $data["lastMonthActivity"] = Activity::
        where('type', 'visit')
        ->where('created_at', '>', Carbon::now()->subMonth())
        ->count();

        $data["lastMonthIncome"] = Order::
        where('delivered_at', '>', Carbon::now()->subMonth())
        ->sum('clean_price')-
        Payement::where('created_at', '>', Carbon::now()
        ->subMonth())
        ->sum('amount');
        
        $data["last2MonthRevenue"] = Order::
        where('delivered_at', '<', Carbon::now()->subMonth())
        ->where('delivered_at', '>', Carbon::now()->subMonths(2))
        ->sum('clean_price');

        $data["last2MonthOrders"] = Order::
        where('delivered_at', '<', Carbon::now()->subMonth())
        ->where('delivered_at', '>', Carbon::now()->subMonths(2))
        ->count();

        $data["last2MonthActivity"] = Activity::
        where('type', 'visit')
        ->where('created_at', '<', Carbon::now()->subMonth())
        ->where('created_at', '>', Carbon::now()->subMonths(2))
        ->count();

        $data["last2MonthIncome"] = Order::
        where('delivered_at', '<', Carbon::now()->subMonth())
        ->where('delivered_at', '>', Carbon::now()->subMonths(2))
        ->sum('clean_price')-Payement::
        where('created_at', '<', Carbon::now()->subMonth())
        ->where('created_at', '>', Carbon::now()->subMonths(2))
        ->sum('amount');

        $data['unconfirmedOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->where("confirmed_at", null)
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $data['canceledOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->where("canceled_at", null)
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $data['totalOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $data['deliveredOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->where('delivered_at', "!=", null)
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $data['backOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->where('back_at', "!=", null)
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });


        if($data["last2MonthIncome"] != 0)
            $data["lastMonthIncomeVar"] = ($data["lastMonthIncome"] - $data["last2MonthIncome"])/$data["last2MonthIncome"]*100;
        else 
            $data["lastMonthIncomeVar"] = 0;
        
        if($data["last2MonthOrders"] != 0)
            $data["lastMonthOrdersVar"] = ($data["lastMonthOrders"] - $data["last2MonthOrders"])/$data["last2MonthOrders"]*100;
        else 
            $data["lastMonthOrdersVar"] = 0;
        
        if($data["last2MonthActivity"] != 0)
            $data["lastMonthActivityVar"] = ($data["lastMonthActivity"] - $data["last2MonthActivity"])/$data["last2MonthActivity"]*100;
        else 
            $data["lastMonthActivityVar"] = 0;
        
        if($data["last2MonthRevenue"] != 0)
            $data["lastMonthRevenueVar"] = ($data["lastMonthRevenue"] - $data["last2MonthRevenue"])/$data["last2MonthRevenue"]*100;
        else 
            $data["lastMonthRevenueVar"] = 0;


        return view("webmaster.dashboard.index")->with("data", $data);
    }
}
