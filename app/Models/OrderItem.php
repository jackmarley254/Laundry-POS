<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',       // <--- ADD THIS
        'service_id',
        'service_name',
        'quantity',
        'price',
        'subtotal',
    ];

    // Optional: Define relationship
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}