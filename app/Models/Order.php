<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    public function State()
    {
        if($this->archived_at != NULL){
            return "Archived";
        }elseif($this->doubled_at != NULL){
            return "Doubled";
        }elseif($this->canceled_at != NULL){
            return "Canceled";
        }elseif($this->failure_at != NULL){
            return "Failure";


        }elseif($this->back_ready_at != NULL){
            return "Back ready";
        }elseif($this->back_at != NULL){
            return "Back";


        }elseif($this->recovered_at != NULL){
            return "Recovered";
        }elseif($this->ready_at != NULL){
            return "Ready";
        }elseif($this->delivered_at != NULL){
            return "Delivered";


        }elseif($this->delivery_at != NULL){
            return "Delivery";
        }elseif($this->validated_at != NULL){
            return "Validated";
        }elseif($this->shipped_at != NULL){
            return "Shipped";


        }elseif($this->confirmed_at != NULL){
            return "Confirmed";
        }else{
            return "Pending";
        }
    }
    public function Product()
    {
        $product = Product::where("id", $this->product)->first();
        if($product)return $product;
        return false;

    }
    public function Add_to_ecotrack()
    {
        if($this->tracking != null) return false;
        $data = array(
            'referece' => config("webmaster.id").$this->id,
            'nom_client' => $this->name,
            'telephone' => $this->phone,
            'telephone_2' => $this->phone2,
            'adresse' => $this->address,
            'code_wilaya' => $this->wilaya,
            'commune' =>  $this->commune,
            'montant' => $this->total_price,
            'remarque' => $this->quantity+" piece(s)",
            'produit' => $this->Produit()->name,
            'type' => 1,
        );
        $response = Http::post(config("webmaster.ecotrack_link"), $data);
        $responseBody = $response->body();
        $this->tracking = 'new_value';
        $this->save();
    }
    public static function Pending()
    {
        return Order::where([
            "shipped_at" => NULL,
            "validated_at" => NULL,
            "delivery_at" => NULL,
            "delivered_at" => NULL,
            "ready_at" => NULL,
            "recovered_at" => NULL,
            "back_at" => NULL,
            "back_ready_at" => NULL,
            "failure_at" => NULL,
            "canceled_at" => NULL,
            "archived_at" => NULL,
            "doubled_at" => NULL,
        ])->orderBy('created_at', 'desc')->paginate(25)->onEachSide(2);
        
    }
    public static function Shipped()
    {
        return Order::where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('shipped_at', '<>', null)
                    ->orWhere('validated_at', '<>', null)
                    ->orWhere('delivery_at', '<>', null);
            })
            ->where('delivered_at', null)
            ->where('ready_at', null)
            ->where('recovered_at', null)
            ->where('back_at', null)
            ->where('back_ready_at', null)
            ->where('failure_at', null)
            ->where('canceled_at', null)
            ->where('archived_at', null)
            ->where('doubled_at', null);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(25)
        ->onEachSide(2);
    }
    public static function Delivered()
    {
        return Order::where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('delivered_at', '<>', null)
                    ->orWhere('ready_at', '<>', null)
                    ->orWhere('recovered_at', '<>', null);
            })
            ->where('back_at', null)
            ->where('back_ready_at', null)
            ->where('failure_at', null)
            ->where('canceled_at', null)
            ->where('archived_at', null)
            ->where('doubled_at', null);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(25)
        ->onEachSide(2);
    }
    public static function Back()
    {
        return Order::where(function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('back_at', '<>', null)
                         ->orWhere('back_ready_at', '<>', null);
            })
            ->where('failure_at', null)
            ->where('canceled_at', null)
            ->where('archived_at', null)
            ->where('doubled_at', null);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(25)
        ->onEachSide(2);
    }
    public static function Archived()
    {
        return Order::where(function ($query) {
            $query->where('failure_at', '<>', null)
                  ->orWhere('canceled_at', '<>', null)
                  ->orWhere('archived_at', '<>', null)
                  ->orWhere('doubled_at', '<>', null);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(25)
        ->onEachSide(2);
    }

}
