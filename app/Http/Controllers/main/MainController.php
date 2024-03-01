<?php

namespace App\Http\Controllers\main;

use App\Models\Page;
use App\Models\Order;
use App\Models\Wilaya;
use App\Models\Commune;
use App\Models\Message;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;

class MainController extends Controller
{
    public function index()
    {
        $data["title"] = 'الصفحة الرئيسية';
        $data["show_custom_category_name"] = false;
        $data["current_page"] = 'home';
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["categories"] = Category::where("is_active", true)->where("deleted_by", null)->get();
        return view("main.index")->with("data", $data);
    }
    public function product($slug)
    {
        $data["product"] = Product::where("slug", $slug)->first();
        if(!$data["product"]){
            return abort(404);
        }
        $data["title"] = $data["product"]->name;
        $data["wilayas"] = Wilaya::all();
        $data["communes"] = Commune::all();
        $data['current_page'] = $data["product"]->slug;
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        return view("main.product")->with("data", $data);
    }
    public function page($slug)
    {
        $data["page"] = Page::where("slug", $slug)->first();
        if(!$data["page"]){
            return abort(404);
        }
        $data["title"] = $data["page"]->name;
        $data['current_page'] = $data["page"]->slug;
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        return view("main.page")->with("data", $data);

    }
    public function order(StoreOrderRequest $request, $product)
    {
        $timestamp = now()->timestamp;
        $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $uniqueNumber = $timestamp . $randomNumber;
        $intern_tracking = str_pad($uniqueNumber, 14, '0', STR_PAD_RIGHT);
        $product = Product::where("slug", $product)->first();
        if(!$product){
            return abort(404);
        }
        $data = array(
            "name" => $request->name,
            "phone" => $request->phone,
            "phone2" => $request->phone2,
            "address" => $request->address,
            "commune" => $request->commune,
            "wilaya" => $request->wilaya,
            "quantity" => $request->quantity,

            "intern_tracking" => config("settings.id").$intern_tracking,
            "total_price" => $request->total_price,
            "delivery_price" => $request->delivery_price,
            "clean_price" => $request->clean_price,

            "ip" => $_SERVER['REMOTE_ADDR'],
            "product" => $product->id,
            "campaign"  => isset($_COOKIE['campaign'])?$_COOKIE['campaign']:null,
        );
        $order = Order::create($data);
        Notification::Send([
            "icon" => "shopping-cart",
            "icon_color" => "success",
            "title" => "New order from ".$order->name,
            "content" => $order->clean_price.' DZD',
            "link" => route('webmaster_orders_all_index'),
        ], "consult_all_orders", true);

        if($request->input('attributes') != null){
        foreach($request->input('attributes') as $key=>$attribute)
        {
                AttributeValue::create([
                    "value" => $attribute,
                    "attribute" => $key,
                    "order" => $order->id
                ]);
            }
        }
        return redirect()->route('main_orders_thankyou', $order->intern_tracking)->with('success', 'تم تسجيل الطلب');
    }

    public function thankyou($order)
    {
        $data["show_custom_category_name"] = "منتجات أخرى قد تهمك";
        $data['current_page'] = $order;
        $data["title"] = "شكرا";
        $data['order'] = Order::where("intern_tracking", $order)->first();
        if(!$data['order']){
            return abort(404);
        }
        $data["categories"] = Category::where("id", $data['order']->Product()->Category()->id)->where("deleted_by", null)->get();
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        return view("main.thankyou")->with("data", $data);

    }

    public function tracking($order)
    {
        $data["show_custom_category_name"] = "منتجات قد تهمك";
        $data['current_page'] = $order;
        $data["title"] = "تتبع الطرود";
        $data['order'] = Order::where("intern_tracking", $order)->first();
        if(!$data['order']){
            return abort(404);
        }
        $data["categories"] = Category::where("id", $data['order']->Product()->Category()->id)->where("deleted_by", null)->get();
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        return view("main.tracking")->with("data", $data);
    }

    public function echange()
    {
        $data['current_page'] = "echange";
        $data["title"] = "طلب تغيير منتج";
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["products"] = Product::all();
        return view("main.echange")->with("data", $data);
    }

    public function contact()
    {
        $data['current_page'] = "contact";
        $data["title"] = "إتصل بنا";
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["products"] = Product::all();
        return view("main.contact")->with("data", $data);
    }

    public function echange_store(Request $request)
    {
        $data = [
            "name" => $request->input('name'), 
            "phone" => $request->input('phone'), 
            "subject" => "طلب تغيير منتج ".Product::where("id", $request->input('product'))->first()->name, 
            "message" => $request->input('motif'),
            "tracking" => $request->input('tracking'),
            "ip" => $_SERVER['REMOTE_ADDR'],
        ];

        $message = Message::create($data);
        
        Notification::Send([
            "icon" => "repeat",
            "icon_color" => "warning",
            "title" => $message->subject,
            "content" => $message->message,
            "link" => route('webmaster_messages_index'),
        ], "consult_all_orders", true);

        return redirect()->route('main_pages_echange')->with('success', 'تمت عملية الإرسال سيتم الرد قريبا');
    }

    public function contact_store(Request $request)
    {
        $data = [
            "name" => $request->input('name'), 
            "phone" => $request->input('phone'), 
            "subject" => $request->input('subject'), 
            "message" => $request->input('message'),
            "ip" => $_SERVER['REMOTE_ADDR'],
        ];
        $message = Message::create($data);
        
        Notification::Send([
            "icon" => "envelope-open-text",
            "icon_color" => "success",
            "title" => $message->subject,
            "content" => $message->message,
            "link" => route('webmaster_messages_index'),
        ], "consult_all_orders", true);

        return redirect()->route('main_pages_contact')->with('success', 'تمت عملية الإرسال سيتم الرد قريبا');
    }

    public function tracking_orders()
    {
        $data['current_page'] = "contact";
        $data["title"] = "تتبع الطرود";
        $data["header_pages"] = Page::where("position", "Header")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages1"] = Page::where("position", "Footer1")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["footer_pages2"] = Page::where("position", "Footer2")->where("is_active", true)->orderBy('created_at', 'desc')->get();
        $data["products"] = Product::all();
        return view("main.tracking_orders")->with("data", $data);
    }

    public function tracking_lookup(Request $request)
    {
        if($request->has("tracking"))
        {
            $order = Order::where("intern_tracking", $request->tracking)->first();
            if($order){
                return redirect()->route('main_orders_tracking', $order->intern_tracking);
            }else{
                return redirect()->route('main_pages_tracking')->with('error', 'يرجى إدخال رقم التتبع الصحيح');
            }
        }
        else
        {
            return redirect()->route('main_pages_tracking')->with('error', 'يرجى إدخال رقم التتبع');
        }
    }
}
