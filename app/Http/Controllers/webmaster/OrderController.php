<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Order;
use App\Models\confirmation_attempt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\Storeconfirmation_attemptRequest;
use App\Http\Requests\Storedelivery_attemptRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Orders managments';
        $data["orders"] = Order::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
        return view("webmaster.orders.index")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function pending_index()
    {
        $data["title"] = 'Pending orders managments';
        $data["orders"] = Order::Pending();
        $data["can_confirm"] = Auth::user()->Has_permission("confirm_orders");
        $data["can_shipp"] = Auth::user()->Has_permission("shipp_orders");
        $data["can_validate"] = Auth::user()->Has_permission("validate_orders");
        return view("webmaster.orders.pending")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function shipped_index()
    {
        $data["title"] = 'Shipped orders managments';
        $data["can_validate"] = Auth::user()->Has_permission("validate_orders");
        $data["orders"] = Order::Shipped();
        $data["can_add_information"] = Auth::user()->Has_permission("add_information_orders");
        return view("webmaster.orders.shipped")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function delivered_index()
    {
        $data["title"] = 'Delivered orders managments';
        $data["can_archive"] = Auth::user()->Has_permission("archive_orders");
        $data["orders"] = Order::Delivered();
        return view("webmaster.orders.delivered")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function back_index()
    {
        $data["title"] = 'Back orders managments';
        $data["can_archive"] = Auth::user()->Has_permission("archive_orders");
        $data["orders"] = Order::back();
        return view("webmaster.orders.back")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function archived_index()
    {
        $data["title"] = 'Archived orders managments';
        $data["orders"] = Order::archived();
        return view("webmaster.orders.archived")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function confirm(Storeconfirmation_attemptRequest $request, Order $order)
    {
        switch($request->input("state")){
            case 'confirmed':
                $data = array(
                    'response' => $request->input('remarque'),
                    "state" => "confirmed",
                    'order' => $order->id,
                    'attempt_by' => Auth::user()->id,
                );
                $order->update([
                    "confirmed_by" => Auth::user()->id,
                    "confirmed_at" => now(),
                ]);
                break;
            case 'not confirmed':
                $data = array(
                    'response'  => $request->input('response'),
                    "state" => "not confirmed",
                    'order' => $order->id,
                    'attempt_by' => Auth::user()->id,
                );
                break;
            case 'canceled':
                $data = array(
                    'response'  => $request->input('response'),
                    "state" => "canceled",
                    'order' => $order->id,
                    'attempt_by' => Auth::user()->id,
                );
                $order->update([
                    "confirmed_by" => Auth::user()->id,
                    "canceled_at" => now(),
                ]);
                break;
        }

        $confirmation_attempt = confirmation_attempt::create($data);
        if($request->has("stopdesk")){
            $order->update([
                "stopdesk" => 1
            ]);
        }
        if($request->has("shipp")){
            $this->shipp($order);
        }
        if($request->has("validate")){
            $this->validate_order($order);
        }

        return redirect()->route('webmaster_orders_pending_index')->with('success', 'Order confirmed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function shipp(Order $order)
    {
        $order->Add_to_ecotrack();
        return redirect()->route('webmaster_orders_shipped_index')->with('success', 'Order shipped successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function validate_order(Order $order)
    {
        $order->Validate_order();
        return redirect()->route('webmaster_orders_shipped_index')->with('success', 'Order Validated successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function archive(Order $order)
    {
        $order->archived_at = now();
        $order->archived_by = Auth::user()->id;
        $order->save();
        return redirect()->route('webmaster_orders_shipped_index')->with('success', 'Order Validated successfully');
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function add_information(Storedelivery_attemptRequest $request, Order $order)
    {
        $order->Add_information($request->input("response"));
        return redirect()->route($request->backto)->with('success', 'Information added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
