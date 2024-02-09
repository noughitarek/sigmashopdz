<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'price',
        'old_price',
        'photos',
        'videos',
        'is_active',
        'description',
        'created_by',
        'category'
    ];

    
    public function Created_by():User
    {
        $user = User::where("id", $this->created_by)->first();
        if($user)return $user;
        return false;
    }
    
    public function Category():Category
    {
        $category = Category::where("id", $this->category)->first();
        if($category)return $category;
        return false;
    }
}
