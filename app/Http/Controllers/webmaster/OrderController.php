<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Order;
use App\Models\confirmation_attempt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\Storeconfirmation_attemptRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Orders managments';
        $data["orders"] = Order::orderBy('created_at', 'desc')->get();
        return view("webmaster.orders.pending")->with("data", $data);
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
        return view("webmaster.orders.pending")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function shipped_index()
    {
        $data["title"] = 'Shipped orders managments';
        $data["orders"] = Order::Shipped();
        return view("webmaster.orders.shipped")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function delivered_index()
    {
        $data["title"] = 'Delivered orders managments';
        $data["orders"] = Order::Delivered();
        return view("webmaster.orders.delivered")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function back_index()
    {
        $data["title"] = 'Back orders managments';
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
        $confirmation_attempt = confirmation_attempt::create([
            'response'  => $request->input('response'),
            'state'  => $request->input('state'),
            'order' => $order->id,
            'attempt_by' => Auth::user()['id'],
        ]);
        if($request->input("state") == "confirmed ecotrack"){
            $order->update([
                "confirmed_by" => Auth::user()->id,
                "confirmed_at" => now(),
            ]);
            $this->shipp($order);
        }
        if($request->input("state") == "confirmed"){
            $order->update([
                "confirmed_by" => Auth::user()->id,
                "confirmed_at" => now(),
            ]);
        }elseif($request->input("state") == "canceled"){
            $order->update([
                "confirmed_by" => Auth::user()->id,
                "canceled_at" => now(),
            ]);
        }
        return redirect()->route('webmaster_orders_pending_index')->with('success', 'Order confirmed successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function shipp(Order $order)
    {
        if($order->tracking != null) return false;
        $order->Add_to_ecotrack();
        return redirect()->route('webmaster_orders_shipped_index')->with('success', 'Order shipped successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
