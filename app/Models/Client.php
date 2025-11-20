<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'username',
        'email',
        'phone',
        'address',
        'note',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    

    // public function carts() {
    //     return $this->hasMany(Cart::class);
    // }
}
