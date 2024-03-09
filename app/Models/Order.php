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
    protected $fillable = ["name", "intern_tracking", "phone", "phone2", "address", "commune", "wilaya", "quantity", "total_price", "delivery_price", "clean_price", "ip",
        "stopdesk", "confirmed_at", "confirmed_by", "shipped_at", "shipped_by", "validated_at", "validated_by", "tracking",
        "delivery_at", "delivered_at", "ready_at", "recovered_at", "recovered_by", "back_at", "back_ready_at",
        "failure_at", "canceled_at", "archived_at", "doubled_at", "product", "campaign", "created_at"];
    
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

    public function Transactions()
    {
        $transactions = [];
        $transactions[$this->created_at->format('Y-m-d H:i:s')] = "تم إستقبال الطلب";
        
        if($this->confirmed_at!=null){
            $transactions[$this->confirmed_at] = "تم تأكيد الطلب";
        }
        if($this->shipped_at!=null){
            $transactions[$this->shipped_at] = "تم شحن الطرد";
        }
        if($this->validated_at!=null){
            $transactions[$this->validated_at] = "تحويل الطرد لمركز الطرود لولاية الجزائر";
        }
        if($this->delivery_at!=null && $this->Wilaya()->id!=16){
            $transactions[$this->delivery_at] = "تحويل الطرد لمركز الطرود لولاية ".$this->Wilaya()->name_ar;
        }
        if($this->delivery_at!=null){
            $transactions[$this->delivery_at." "] = "شحن الطرد ".($this->stopdesk?"لمكتب التوصيل":"لمنزل الزبون");
        }
        if($this->delivered_at!=null){
            $transactions[$this->delivered_at] = "وصول الطرد للزبون";
        }
        if($this->back_at!=null){
            $transactions[$this->back_at] = "إرجاع الطرد";
        }
        if($this->canceled_at!=null){
            $transactions[$this->canceled_at] = "إلغاء الطلب";
        }
        if($this->failure!=null){
            $transactions[$this->failure] = "فشل العملية";
        }
        uksort($transactions, array($this, 'compareDates'));
        return $transactions;
    }
    public function compareDates($a, $b)
    {
        $dateA = strtotime($a);
        $dateB = strtotime($b);
    
        if ($dateA == $dateB) {
            return 0;
        }
    
        return ($dateA < $dateB) ? -1 : 1;
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
            'referece' => $this->intern_tracking,
            'nom_client' => $this->name,
            'telephone' => $this->phone,
            'telephone_2' => $this->phone2,
            'adresse' => $this->address,
            'fragile' => true,
            'quantity' => 5,
            'code_wilaya' => $this->wilaya,
            'commune' =>  $this->Commune()->name,
            'stop_desk' => $this->stopdesk,
            'montant' => $this->total_price,
            'remarque' => implode(' | ', $remarques),
            'produit' => $this->Product()->slug,
            'type' => 1,
            'api_token' => config("settings.ecotrack_api")
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/create/order";
        $resultData = self::Send_API($apiUrl, $data, "POST");
        if ($resultData && isset($resultData['tracking']))
        {
            $this->tracking = $resultData['tracking'];
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

    public function Validate_order()
    {
        $data = array(
            "tracking" => $this->tracking,
            'api_token' => config("settings.ecotrack_api")
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/valid/order";
        $resultData = self::Send_API($apiUrl, $data, "POST");
        if ($resultData && isset($resultData['success']) && $resultData['success'])
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

    public function Update_state()
    {
        $data = array(
            "trackings" => $this->tracking,
            "status" => "all",
            'api_token' => config("settings.ecotrack_api")
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/get/orders/status";
        $resultData = self::Send_API($apiUrl, $data, "GET");
        if(isset($resultData["data"])){
            foreach($resultData["data"] as $token=>$activity){
                $s = $activity['status'];
                if($this->shipped_at == null && ($s == "prete_a_expedier")){
                    $this->shipped_at = now();
                }elseif($this->validated_at == null && ($s == "en_preparation_stock" || $s == "vers_hub")){
                    $this->validated_at = now();
                }elseif($this->delivery_at == null && ($s == "en_hub" || $s == "vers_wilaya" || $s == "en_preparation" || $s == "en_livraison")){
                    $this->delivery_at = now();
                }elseif($this->back_at == null && ($s == "suspendu" || $s == "retour_chez_livreur" || $s == "retour_transit_entrepot")){
                    $this->back_at = now();
                }elseif($this->back_ready_at == null && ($s == "retour_en_traitement" || $s == "retour_recu" || $s == "retour_archive")){
                    $this->back_ready_at = now();
                }elseif($this->delivered_at == null && ($s == "livre_non_encaisse")){
                    $this->delivered_at = now();
                }elseif($this->ready_at == null && ($s == "encaisse_non_paye" || $s == "paiements_prets")){
                    $this->ready_at = now();
                }elseif($this->recovered_at == null && ($s == "paye_et_archive")){
                    $this->recovered_at = now();
                }
                $this->save();
            }
        }else{
            return false;
        }

    }
    
    public function Update_state2()
    {
        $data = array(
            'tracking' => $this->tracking,
            'api_token' => config("settings.ecotrack_api")
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/get/tracking/info";
        $resultData = self::Send_API($apiUrl, $data, "GET");
        if(isset($resultData["activity"])){
            foreach($resultData["activity"] as $activity){
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

    public function Get_information()
    {
        $data = array(
            'tracking' => $this->tracking,
            'api_token' => config("settings.ecotrack_api")
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/get/maj";
        $resultData = self::Send_API($apiUrl, $data, "GET");

        foreach($resultData as $attempt){
            if(!isset($attempt["created_at"]))continue;
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
    }

    public function Add_information($information)
    {
        $data = array(
            'content' => $information,
            'tracking' => $this->tracking,
            'api_token' => config("settings.ecotrack_api")
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/add/maj";
        $resultData = self::Send_API($apiUrl, $data, "POST");
        
        if ($resultData && isset($resultData['success']) && $resultData['success'])
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
        return new Product([
            "name" => "n/a"
        ]);
    }

    public function Campaign()
    {
        $campaign = Campaign::where("id", $this->campaign)->first();
        if($campaign)return $campaign;
        return new Campaign([
            "name" => "n/a"
        ]);
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

    public function Status()
    {
        $status = [];
        if($this->confirmed_at != null){
            $status[] = ["success", "Confirmed"];
        }else{
            $status[] = ["danger", "Not confirmed"];
        }
        
        if($this->shipped_at != null){
            $status[] = ["success", "Shipped"];
        }else{
            $status[] = ["danger", "Not shipped"];
        }
        
        if($this->validated_at != null){
            $status[] = ["success", "Validated"];
        }else{
            $status[] = ["danger", "Not validated"];
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
    
    public static function Save_orders()
    {

        $orders = self::Get_orders();
        foreach($orders as $order){
        
            $timestamp = now()->timestamp;
            $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $uniqueNumber = $timestamp . $randomNumber;
            $intern_tracking = str_pad($uniqueNumber, 14, '0', STR_PAD_RIGHT);
            $data = array(
                "name" => $order['client'],
                "phone" => $order['phone'],
                "phone2" => $order['phone_2'],
                "address" => $order['adresse'],
                "commune" => Commune::where("name", $order['commune'])->first()->id,
                "wilaya" => $order['wilaya_id'],
                "quantity" => 0,
                "intern_tracking" => config("settings.id").$intern_tracking,
                "total_price" => $order['montant'],
                "delivery_price" => $order['tarif_prestation'],
                "clean_price" => $order['montant']-$order['tarif_prestation'],
                "tracking" => $order['tracking'],
                "created_at" => $order['created_at'],
                "ip" => "n/a",
            );
            Order::create($data);
        }
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
        ])->orderBy('created_at', 'desc')->get();
        
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
        ->orderBy('created_at', 'desc')->get();
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
        ->orderBy('created_at', 'desc')->get();
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
        ->orderBy('created_at', 'desc')->get();
    }

    public static function Archived()
    {
        return Order::where(function ($query) {
            $query->where('failure_at', '<>', null)
                  ->orWhere('canceled_at', '<>', null)
                  ->orWhere('archived_at', '<>', null)
                  ->orWhere('doubled_at', '<>', null);
        })
        ->orderBy('created_at', 'desc')->get();
    }
    
    public static function Get_orders($page=1)
    {
        $data = array(
            'api_token' => config("settings.ecotrack_api"),
            'start_date' => '2024-02-15',
            "page" => $page,
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/get/orders";
        $resultData = self::Send_API($apiUrl, $data, "GET");
        if(count($resultData["data"])>0){
            return array_merge(self::Get_orders($page+1), $resultData["data"]);
        }else{
            return [];
        }
    }

    public static function Send_API0($url, $data, $type="POST")
    {
        if($type == "GET"){
            $submitUrl = $url.'?' . http_build_query($data);
        }else{
            $submitUrl = $url;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $submitUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($type == "POST"){
            
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . config("settings.ecotrack_api"),
            'Content-Type: application/x-www-form-urlencoded',
        ));
        $result = curl_exec($ch);
        
        if (curl_errno($ch))
        {
            echo 'Error: Can\'t send api request\n';
            sleep(10);
            return self::Send_API($url, $data, $type);
        }
        elseif($result)
        {
            $resultData = json_decode($result, true);
            curl_close($ch);
            if(isset($resultData['message']) && $resultData['message'] == "Too Many Attempts.")
            {
                echo 'Error: Too Many Attempts\n';
                sleep(10);
                return self::Send_API($url, $data, $type);
            }
            else
            {
                return $resultData;
            }
        }
        else
        {
            echo 'Error: Can\'t send api request 2\n';
            sleep(10);
            return self::Send_API($url, $data, $type);
        }

    }
    public static function Send_API($url, $data, $type="POST")
    {
        $data0 = array(
            'api_token' => config("settings.ecotrack_api"),
            'url' => base64_encode($url),
            'typeRequest' => $type=="POST"?'post':'get'
        );

        $helperUrl = "https://sigma-helper.000webhostapp.com/".'?' . http_build_query(array_merge($data, $data0));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $helperUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
        ));
        $result = curl_exec($ch);
        
        if (curl_errno($ch))
        {
            echo 'Error: Can\'t send api request\n';
        }
        elseif($result)
        {
            $resultData = json_decode($result, true);
            curl_close($ch);
            if(isset($resultData['message']) && $resultData['message'] == "Too Many Attempts.")
            {
                echo 'Error: Too Many Attempts\n';
            }
            else
            {
                return $resultData;
            }
        }
        else
        {
            echo 'Error: Can\'t send api request 2\n';
        }

    }
    public function Attributes()
    {
        return AttributeValue::where('order', $this->id)->get();
    }
}
