<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Payement;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone2',

        'role',
        'permissions',

        'password',
        'profile_image',
        'is_active',
        'last_login_at',

        'created_by'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function Has_Permission($permission)
    {
        if(in_array($permission, explode(",", $this->permissions))){
            return true;
        }
        return false;
        
    }
    
    public function Created_by():User
    {
        $user = User::where("id", $this->created_by)->first();
        if($user)return $user;
        return new User(['name'=>'n/a']);
    }
    public function Notifications()
    {
        return Notification::where("sent_to", $this->id)->where('readed', false)->orderBy('created_at', 'desc')->get();
    }
    public function Amount():float
    {
        $payements = Payement::where("payed_by", $this->id)->orWhere('payed_to', $this->id)->get();
        $orders = Order::where("recovered_by", $this->id)->where("recovered_at", "!=", null)->get();
        $amount = 0;
        foreach($payements as $payement){
            if($payement->payed_by == $this->id){
                $amount -= $payement->amount;
            }
            if($payement->payed_to == $this->id){
                $amount += $payement->amount;
            }
        }
        foreach($orders as $order){
            $amount += $order->clean_price;
        }
        return $amount;
    }
    public function Profile_image()
    {
        if($this->profile_image != NULL){   
            return asset('img/avatars/'.$this->profile_image);
        }else{
            return asset('img/avatars/unknown.png');
        }
    }
    public function Permissions()
    {
        $permissions = explode(",", $this->permissions);
        $p = [];
        foreach($permissions as $permission){
            $title = explode("_", $permission)[count(explode("_", $permission))-1];
            if(!isset($p[$title])){
                $p[$title] = [];
            }

            $p[$title][] = $permission;
        }
        print_r($p);
        return [];
    }
}
