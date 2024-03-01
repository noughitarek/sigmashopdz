<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $data["can_create"] = Auth::user()->Has_permission("create_products");
        $data["can_edit"] = Auth::user()->Has_permission("edit_products");
        $data["products"] = Product::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
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
        $photos = $request->file('photos');
        $photosNames = [];
        foreach($photos as $photo){
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('img/products'), $photoName);
            $photosNames[] = $photoName;
        }
        

        $product = Product::create([
            'name'  => $request->input('name'),
            'slug'  => $request->input('slug'),

            'price' => $request->input('price'),
            'old_price' => $request->input('old_price')?$request->input('old_price'):null,
            
            'photos' => implode(',', $photosNames),
            'videos' => implode(',', $request->videos),

            'is_active'  => $request->input('is_active'),
            'description' => $request->input('description'),

            'created_by' => Auth::user()['id'],
            'category' => $request->category,
        ]);
        return redirect()->route('webmaster_products_index')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $data["title"] = 'Product '.$product["id"];
        $data["product"] = $product;
        
        $data["can_create"] = Auth::user()->Has_permission("create_products");
        $data["can_delete"] = Auth::user()->Has_permission("delete_products");
        $data["can_edit"] = Auth::user()->Has_permission("edit_products");
        return view("webmaster.products.show")->with("data", $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data["title"] = 'Edit product '.$product->id;
        $data["product"] = $product;
        $data["categories"] = Category::all();
        return view("webmaster.products.edit")->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        
        $photos = $request->file('photos');
        $photosNames = [];
        if($photos!=null){
            foreach($photos as $photo){
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('img/products'), $photoName);
                $photosNames[] = $photoName;
            }
        }
        if($request->old_photos!=null){
            foreach($request->old_photos as $photo){
                $photosNames[] = $photo;
            }
        }
        $videos = [];
        if($request->videos!=null){
            foreach($request->videos as $video){
                $videos[] = $video;
            }
        }
        if($request->old_videos!=null){
            foreach($request->old_videos as $video){
                $videos[] = $photo;
            }
        }

        $product->update([
            'name'  => $request->input('name'),
            'slug'  => $request->input('slug'),

            'price' => $request->input('price'),
            'old_price' => $request->input('old_price')?$request->input('old_price'):null,
            
            'photos' => implode(',', $photosNames),
            'videos' => implode(',', $videos),

            'is_active'  => $request->input('is_active'),
            'description' => $request->input('description'),

            'category' => $request->category,
        ]);
        return redirect()->route('webmaster_products_index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
