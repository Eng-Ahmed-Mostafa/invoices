<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'total_amount',
        'status',
        'cart_id'
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    // Calculate due date based on invoice date and due time
    public function dueDate($invoice_date,$days = 7) {
        if (!$this->due_date) {
            $this->due_date = Carbon::parse($invoice_date)
                ->addDays((int)$days);
        }
        return $this->due_date ?? Carbon::parse($invoice_date)->addDays(7);
    }

    // Calculate total amount based on associated products
    public function calcTotalAmount($products)
    {
        $total = 0;

        foreach ($products as $product) {
            $total += $product->price * $product->pivot->quantity;
        }

        $this->total_amount = $total;

        return $this->total_amount;
    }

    
    
}
