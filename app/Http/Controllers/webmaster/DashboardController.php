<?php

namespace App\Http\Controllers\webmaster;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Payement;
use App\Models\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data["title"] = 'Dashboard';
        $data['products'] = Product::all();
        $data["dashboard"] = Dashboard::class;
        return view("webmaster.dashboard.index")->with("data", $data);
        
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

        $data['products'] = Product::all();
        $data['totalOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $data['deliveryOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->where("delivery_at", "!=", null)
        ->where("canceled_at", null)
        ->where("delivered_at", null)
        ->where("back_at", null)
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

        $data['canceledOrdersPerDay'] = Order::
        where('created_at', '>', Carbon::now()->subMonth())
        ->where("canceled_at", "!=", null)
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

        $data['pendingOrdersPerDay'] = $data['totalOrdersPerDay']->count()
            - $data['backOrdersPerDay']->count()
            - $data['deliveredOrdersPerDay']->count()
            - $data['canceledOrdersPerDay']->count()
            - $data['deliveryOrdersPerDay']->count();


        $data['payedUnvalidated'] = Order::where("recovered_by", null)->where("recovered_at", "!=", null)->sum("clean_price");

        if($data["last2MonthIncome"] != 0)
            $data["lastMonthIncomeVar"] = (int)(($data["lastMonthIncome"] - $data["last2MonthIncome"])/$data["last2MonthIncome"]*100);
        else 
            $data["lastMonthIncomeVar"] = 0;
        
        if($data["last2MonthOrders"] != 0)
            $data["lastMonthOrdersVar"] = (int)(($data["lastMonthOrders"] - $data["last2MonthOrders"])/$data["last2MonthOrders"]*100);
        else 
            $data["lastMonthOrdersVar"] = 0;
        
        if($data["last2MonthActivity"] != 0)
            $data["lastMonthActivityVar"] = (int)(($data["lastMonthActivity"] - $data["last2MonthActivity"])/$data["last2MonthActivity"]*100);
        else 
            $data["lastMonthActivityVar"] = 0;
        
        if($data["last2MonthRevenue"] != 0)
            $data["lastMonthRevenueVar"] = (int)(($data["lastMonthRevenue"] - $data["last2MonthRevenue"])/$data["last2MonthRevenue"]*100);
        else 
            $data["lastMonthRevenueVar"] = 0;


        return view("webmaster.dashboard.index")->with("data", $data);
    }
}
