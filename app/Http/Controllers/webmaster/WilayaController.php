<?php

namespace App\Http\Controllers\webmaster;

use App\Models\Wilaya;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateDeliveryRequest;

class WilayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["title"] = 'Delivery prices managments';
        $data["wilayas"] = Wilaya::orderBy('id', 'asc')->get();
        $data["can_edit"] = Auth::user()->Has_permission("edit_delivery");
        return view("webmaster.delivery.index")->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryRequest $request)
    {
        $data = [];
        $wilayas = Wilaya::orderBy('id', 'asc')->get();
        foreach($wilayas as $wilaya){
            print_r([
                'real_price' => $request->input('real_price_'.$wilaya->id),
                'shown_price' => $request->input('shown_price_'.$wilaya->id)
            ]);
            $wilaya->update([
                'real_price' => $request->input('real_price_'.$wilaya->id),
                'shown_price' => $request->input('shown_price_'.$wilaya->id)
            ]);
            $wilaya->save();
        }
        return redirect()->route('webmaster_delivery_index')->with('success', 'Delivery prices updated successfully');
    }
}
