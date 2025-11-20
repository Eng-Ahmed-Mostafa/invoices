<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'image',
        'price',
        'quantity',
        'description',
        'user_id'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function carts() {
    //     return $this->belongsToMany(Cart::class, 'cart_product')->withPivot('quantity');
    // }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    
}
