<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ["quantity", "total_price", "created_by", "payed_by", "product"];
    
    public function Product()
    {
        $product = Product::where("id", $this->product)->first();
        return $product;
    }
}
