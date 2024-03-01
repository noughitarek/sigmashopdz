<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ["title", "values", "title_ar", "values_ar", "created_by", "product"];
    
    public function Created_by():User
    {
        $user = User::where("id", $this->created_by)->first();
        if($user)return $user;
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

}
