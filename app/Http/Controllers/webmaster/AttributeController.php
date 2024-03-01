<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Product;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Attributes managments';
        $data["attributes"] = Attribute::orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
        $data["can_create"] = Auth::user()->Has_permission("create_attributes");
        $data["can_edit"] = Auth::user()->Has_permission("edit_attributes");
        $data["can_delete"] = Auth::user()->Has_permission("delete_attributes");
        return view("webmaster.attributes.index")->with("data", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data["title"] = 'Create an attribute';
        $data["products"] = Product::all();
        return view("webmaster.attributes.create")->with("data", $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        $data = array(
            'title' => $request->input("title"),
            'values' => $request->input("values"),
            'title_ar' => $request->input("title_ar"),
            'values_ar' => $request->input("values_ar")=="null"?null:$request->input("values_ar"),
            'product' => $request->input("product"),
            'created_by' => Auth::user()->id
        );
        Attribute::create($data);
        return redirect()->route('webmaster_attributes_index')->with('success', 'Attribute deleted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        //
    }
}
