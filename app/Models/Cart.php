<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'client_id',
        'product_id',
        'quantity'
    ];


    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class, 'cart_product')->withPivot('quantity');
    }

    public function invoice() {
        return $this->hasOne(Invoice::class);
    }
}
