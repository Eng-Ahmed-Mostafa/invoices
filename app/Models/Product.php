<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'image',
        'price',
        'user_id'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function carts() {
        return $this->belongsToMany(Cart::class, 'cart_product')->withPivot('quantity');
    }
    
}
