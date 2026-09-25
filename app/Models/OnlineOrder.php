<?php
// app/Models/OnlineOrder.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineOrder extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'phone', 'email', 'delivery_address',
        'service_name', 'quantity', 'items',
        'pickup_date', 'pickup_time', 'notes',
        'total_amount', 'payment_status', 'status',
    ];

    protected $casts = [
        'items'       => 'array',
        'pickup_date' => 'date',
        'total_amount'=> 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (OnlineOrder $order) {
            // ON-20260925-XXXX, generated automatically so the form never needs to send one
            $order->order_number ??= 'ON-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        });
    }
}