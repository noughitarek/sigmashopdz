<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Products managments';
        $data["products"] = Product::orderBy('created_at', 'desc')->paginate(25);
        return view("webmaster.products.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["title"] = 'Create a product';
        $data["categories"] = Category::all();
        return view("webmaster.products.create")->with("data", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
