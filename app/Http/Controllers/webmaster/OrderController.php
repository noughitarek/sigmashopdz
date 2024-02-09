<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Orders managments';
        $data["orders"] = Order::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);;
        return view("webmaster.orders.pending")->with("data", $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function pending_index()
    {
        $data["title"] = 'Pending orders managments';
        $data["orders"] = Order::Pending();
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
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
