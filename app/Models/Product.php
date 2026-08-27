<?php

namespace App\Models;

use App\Trait\HashSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HashSlug, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'price',
        'quantity',
        'description',
        'user_id',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
