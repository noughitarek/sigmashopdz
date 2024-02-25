<?php

namespace App\Http\Controllers\main;

use App\Models\Page;
use App\Models\Order;
use App\Models\Wilaya;
use App\Models\Commune;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;

class MainController extends Controller
{
    public function index()
    {
        $data["title"] = 'الصفحة الرئيسية';
        $data["current_page"] = 'home';
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->get();
        $data["categories"] = Category::where("is_active", true)->get();
        return view("main.index")->with("data", $data);
    }
    public function product($slug)
    {
        $data["product"] = Product::where("slug", $slug)->first();
        $data["title"] = $data["product"]->name;
        $data["wilayas"] = Wilaya::all();
        $data["communes"] = Commune::all();
        $data['current_page'] = $data["product"]->slug;
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->get();
        return view("main.product")->with("data", $data);
    }
    public function order(StoreOrderRequest $request, $product){
        $product = Product::where("slug", $product)->first();
        $data = array(
            "name" => $request->name,
            "phone" => $request->phone,
            "phone2" => $request->phone2,
            "address" => $request->address,
            "commune" => $request->commune,
            "wilaya" => $request->wilaya,
            "quantity" => $request->quantity,

            "total_price" => $request->total_price,
            "delivery_price" => $request->delivery_price,
            "clean_price" => $request->clean_price,

            "ip" => $_SERVER['REMOTE_ADDR'],
            "product" => $product->id,
            "campaign"  => isset($_COOKIE['campaign'])?$_COOKIE['campaign']:null,
        );
        Order::create($data);
    }
}
