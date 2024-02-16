<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class confirmation_attempt extends Model
{
    use HasFactory;
    protected $fillable = ['response', 'state', 'order', 'attempt_by'];
        
    public function Attempt_by():User
    {
        $user = User::where("id", $this->attempt_by)->first();
        if($user)return $user;
        return false;
    }
}
