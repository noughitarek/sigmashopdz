<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ["confirmed_at", "confirmed_by", "canceled_at", "shipped_at"];
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
    public function Confirmed_by():User
    {
        $user = User::where("id", $this->confirmed_by)->first();
        if($user)return $user;
        return new User(['name'=>'n/a']);
    }
    public function Shipped_by():User
    {
        $user = User::where("id", $this->shipped_by)->first();
        if($user)return $user;
        return new User(['name'=>'n/a']);
    }
    public function Recovered_by():User
    {
        $user = User::where("id", $this->recovered_by)->first();
        if($user)return $user;
        return new User(['name'=>'n/a']);
    }
    public function Validated_by():User
    {
        $user = User::where("id", $this->validated_by)->first();
        if($user)return $user;
        return new User(['name'=>'n/a']);
    }
    public function Get_information()
    {
        $data = array(
            'tracking' => $this->tracking,
            'api_token' => config("webmaster.ecotrack_api")
        );
        $apiUrl = config("webmaster.ecotrack_link")."api/v1/get/maj";
        $apiUrl .= '?' . http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . config("webmaster.ecotrack_api"),
            'Content-Type: application/x-www-form-urlencoded',
        ));

        $result = curl_exec($ch);
        $responseData = json_decode($result, true);
        foreach($responseData as $attempt){
            $oldAttempt = delivery_attempt::where("created_at", $attempt["created_at"])->first();
            if(!$oldAttempt){
                delivery_attempt::create([
                    "response" => $attempt["remarque"],
                    "order" =>  $this->id,
                    "delivery_man" => $attempt["livreur"], 
                    "station" => $attempt["station"],
                    "created_at" => $attempt["created_at"]
                ]);
            }
        }
        curl_close($ch);
    }
    public function Add_information($information)
    {
        $data = array(
            'content' => $information,
            'tracking' => $this->tracking,
            'api_token' => config("webmaster.ecotrack_api")
        );
        $apiUrl = config("webmaster.ecotrack_link")."api/v1/add/maj";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . config("webmaster.ecotrack_api"),
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        if (curl_errno($ch))
        {
            return false;
        }
        curl_close($ch);
        if ($response)
        {
            $responseData = json_decode($response, true);
            if ($responseData && isset($responseData['success']) && $responseData['success'])
            {
                delivery_attempt::create([
                    "response" => $information,
                    "order" =>  $this->id,
                    "delivery_man" => null, 
                    "station" => null,
                    "attempt_by" => Auth::user()->id,
                ]);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    public function Delivery_attempts()
    {
        $attempts = delivery_attempt::where("order", $this->id)->orderBy('created_at', 'desc')->get();
        if($attempts)return $attempts;
        return false;
    }
    public function Confirmation_attempts()
    {
        $attempts = confirmation_attempt::where("order", $this->id)->get();
        if($attempts)return $attempts;
        return false;
    }
    public function Product()
    {
        $product = Product::where("id", $this->product)->first();
        if($product)return $product;
        return false;
    }
    public function Campaign()
    {
        $campaign = Campaign::where("id", $this->campaign)->first();
        if($campaign)return $campaign;
        return false;
    }
    public function Wilaya()
    {
        $wilaya = Wilaya::where("id", $this->wilaya)->first();
        if($wilaya)return $wilaya;
        return false;
    }
    public function Commune()
    {
        $commune = Commune::where("id", $this->commune)->first();
        if($commune)return $commune;
        return false;
    }
    public function Add_to_ecotrack()
    {
        $response = ""; 
        foreach($this->Confirmation_attempts() as $attempt){
            if($attempt->state == "confirmed" || $attempt->state == "confirmed ecotrack"){
                $response .= $attempt->Attempt_by()->name.':'.$attempt->response.' | ';
            }
        }
        $remarques = array(
            $this->quantity==1?$this->quantity." piece":$this->quantity." pieces",
            $response,
        );
        $data = array(
            'referece' => config("webmaster.id").$this->id,
            'nom_client' => $this->name,
            'telephone' => $this->phone,
            'telephone_2' => $this->phone2,
            'adresse' => $this->address,
            'code_wilaya' => $this->wilaya,
            'commune' =>  $this->Commune()->name,
            'montant' => $this->total_price,
            'remarque' => implode(' | ', $remarques),
            'produit' => $this->Product()->name,
            'type' => 1,
            'api_token' => config("webmaster.ecotrack_api")
        );

        $apiUrl = config("webmaster.ecotrack_link")."api/v1/create/order";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . config("webmaster.ecotrack_api"),
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        if (curl_errno($ch))
        {
            return false;
        }
        curl_close($ch);
        if ($response)
        {
            $responseData = json_decode($response, true);
            if ($responseData && isset($responseData['tracking']))
            {
                $this->tracking = $responseData['tracking'];
                $this->shipped_at = now();
                $this->shipped_by = Auth::user()->id;
                $this->save();
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    public function Validate_order()
    {
        $data = array(
            "tracking" => $this->tracking,
            'api_token' => config("webmaster.ecotrack_api")
        );

        $apiUrl = config("webmaster.ecotrack_link")."api/v1/valid/order";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . config("webmaster.ecotrack_api"),
            'Content-Type: application/x-www-form-urlencoded',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        if (curl_errno($ch))
        {
            return false;
        }
        curl_close($ch);
        if ($response)
        {
            $responseData = json_decode($response, true);
            if ($responseData && isset($responseData['success']) && $responseData['success'])
            {
                $this->validated_at = now();
                $this->validated_by = Auth::user()->id;
                $this->save();
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    public function Update_state()
    {
        $data = array(
            'tracking' => $this->tracking,
            'api_token' => config("webmaster.ecotrack_api")
        );
        $apiUrl = config("webmaster.ecotrack_link")."api/v1/get/tracking/info";
        $apiUrl .= '?' . http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . config("webmaster.ecotrack_api"),
            'Content-Type: application/x-www-form-urlencoded',
        ));

        $result = curl_exec($ch);
        $responseData = json_decode($result, true);
        if(isset($responseData["activity"])){
            foreach($responseData["activity"] as $activity){
                if($activity['status']== "order_information_received_by_carrier" && $this->shipped_at == null){
                    $this->shipped_at = $activity['date']." ".$activity['time'];
                    $this->save();
                }elseif($activity['status']== "notification_on_order" && $this->validated_at == null){
                    $this->validated_at = $activity['date']." ".$activity['time'];
                    $this->save();
                }elseif($activity['status']== "accepted_by_carrier" && $this->delivery_at == null){
                    $this->delivery_at = $activity['date']." ".$activity['time'];
                    $this->save();
                }elseif($activity['status']== "livred" && $this->delivered_at == null){
                    $this->delivered_at = $activity['date']." ".$activity['time'];
                    $this->save();
                }elseif($activity['status']== "encaissed" && $this->ready_at == null){
                    $this->ready_at = $activity['date']." ".$activity['time'];
                    $this->save();
                }elseif($activity['status']== "payed" && $this->recovered_at == null){
                    $this->recovered_at = $activity['date']." ".$activity['time'];
                    $this->save();
                }elseif($activity['status']== "return_in_transit" && $this->back_at == null){
                    $this->back_at = $activity['date']." ".$activity['time'];
                    $this->save(); 
                }elseif($activity['status']== "returned" && $this->back_ready_at == null){
                    $this->back_ready_at = $activity['date']." ".$activity['time'];
                    $this->save();
                }
            }
        }else{
            $this->archived_at = now();
            $this->save();
        }
        curl_close($ch);
    }
    public function Status()
    {
        $status = [];
        if($this->confirmed_at != null){
            $status[] = ["success", "Confirmed"];
        }
        if($this->shipped_at != null){
            $status[] = ["success", "Shipped"];
        }
        if($this->validated_at != null){
            $status[] = ["success", "Validated"];
        }
        if($this->delivery_at != null){
            $status[] = ["success", "Delivery"];
        }
        if($this->delivered_at != null){
            $status[] = ["success", "Delivered"];
        }
        if($this->ready_at != null){
            $status[] = ["success", "Ready"];
        }
        if($this->recovered_at != null){
            $status[] = ["success", "Recovered"];
        }
        if($this->back_at != null){
            $status[] = ["danger", "Back"];
        }
        if($this->back_ready_at != null){
            $status[] = ["danger", "Back ready"];
        }
        if($this->failure_at != null){
            $status[] = ["danger", "Failure"];
        }
        if($this->canceled_at != null){
            $status[] = ["danger", "Canceled"];
        }
        if($this->doubled_at != null){
            $status[] = ["danger", "Doubled"];
        }
        if($this->archived_at != null){
            $status[] = ["danger", "Archived"];
        }
        return $status;
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
