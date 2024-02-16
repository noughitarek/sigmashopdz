<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class delivery_attempt extends Model
{
    use HasFactory;
    protected $fillable = ["response", "order", "delivery_man", "station", "attempt_by", "created_at"];
    public function Attempt_by():User
    {
        $user = User::where("id", $this->attempt_by)->first();
        if($user){
            return $user;
        }
        elseif($this->delivery_man != "" || $this->station != ""){
            return new User(['name' => $this->delivery_man.':'.$this->station]);
        }
        return new User(['name'=> 'n/a']);
    }
}
