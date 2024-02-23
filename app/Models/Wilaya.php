<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'real_price', 'shown_price'];

    
    public function Communes()
    {
        $communes = Commune::where("wilaya", $this->id)->get();
        if($communes)return $communes;
        return false;
    }
}
