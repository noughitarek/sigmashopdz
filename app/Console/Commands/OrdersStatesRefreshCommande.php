<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class OrdersStatesRefreshCommande extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-orders-states';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        #Order::Save_orders();
        $orders = Order::orderBy('updated_at', 'asc')->get();
        $ordersToUpdate = [];

        foreach($orders as $order){
            if(($order->State() != "Archived" && 
                $order->State() != "Doubled" && 
                $order->State() != "Canceled" && 
                $order->State() != "Failure" && 
                $order->State() != "Back ready" &&
                $order->State() != "Recovered" &&
                $order->State() != "Pending") || 
                ($order->State() == "Pending" && $order->tracking != null)
            )
            {
                $ordersToUpdate[] = $order;
            }
            if($order->State() == "Delivery" || $order->State() == "Shipped" || $order->State() == "Validated"){
                #$order->Get_information();
            }
        }
        $orders = array_chunk($ordersToUpdate, 96);
        foreach($orders as $page){
            $this->Update_state($page);
        }
    }
    public function Update_state($orders)
    {
        $trackings = [];
        foreach($orders as $order){
            $trackings[] = $order->tracking;
        }
        $data = array(
            "trackings" => implode(',', $trackings),
            "status" => "all",
            'api_token' => config("settings.ecotrack_api")
        );
        $apiUrl = config("settings.ecotrack_link")."api/v1/get/orders/status";
        $resultData = Order::Send_API($apiUrl, $data, "GET");

        if(isset($resultData["data"])){
            foreach($resultData["data"] as $tracking=>$status){
                $status = $status["status"];
                $order = Order::where('tracking', $tracking)->first();
                if($order->shipped_at == null && ($status == "prete_a_expedier")){
                    $order->shipped_at = now();
                }elseif($order->validated_at == null && ($status == "en_preparation_stock" || $status == "vers_hub")){
                    $order->validated_at = now();
                }elseif($order->delivery_at == null && ($status == "en_hub" || $status == "vers_wilaya" || $status == "en_preparation" || $status == "en_livraison")){
                    $order->delivery_at = now();
                }elseif($order->back_at == null && ($status == "suspendu" || $status == "retour_chez_livreur" || $status == "retour_transit_entrepot")){
                    $order->back_at = now();
                }elseif($order->back_ready_at == null && ($status == "retour_en_traitement" || $status == "retour_recu" || $status == "retour_archive")){
                    $order->back_ready_at = now();
                }elseif($order->delivered_at == null && ($status == "livre_non_encaisse")){
                    $order->delivered_at = now();
                }elseif($order->ready_at == null && ($status == "encaisse_non_paye" || $status == "paiements_prets")){
                    $order->ready_at = now();
                }elseif($order->recovered_at == null && ($status == "paye_et_archive")){
                    $order->recovered_at = now();
                }
                $order->save();
            }
        }else{
            return false;
        }

    }
}

