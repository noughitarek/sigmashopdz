<?php

namespace App\Http\Controllers\webmaster;

use App\Models\User;
use App\Models\Stock;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Stock managments';
        $data["can_create"] = Auth::user()->Has_permission("create_stock");
        $data["can_edit"] = Auth::user()->Has_permission("edit_stock");
        $data["can_delete"] = Auth::user()->Has_permission("delete_stock");
        $data["products"] = Product::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
        return view("webmaster.stock.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["title"] = 'Craete a stock';
        $data["products"] = Product::orderBy('created_at', 'desc')->get();
        $data["admins"] = User::orderBy('created_at', 'desc')->get();
        return view("webmaster.stock.create")->with("data", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $data = array(
            "quantity" => $request->input("quantity"),
            "total_price" => $request->input("total_price"),
            "payed_by" => $request->input("payed_by"),
            "product" => $request->input("product"),
            "created_by" => Auth::user()->id
        );
        Stock::create($data);
        return redirect()->route('webmaster_stock_index')->with('success', 'Stock created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
