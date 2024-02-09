<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'order',
        'created_by',
        'is_active'
    ];
    public function Created_by():User
    {
        $user = User::where("id", $this->created_by)->first();
        if($user)return $user;
        return false;
    }
    public function Products()
    {
        $products = Product::where("category", $this->id)->get();
        return $products;
    }
}
