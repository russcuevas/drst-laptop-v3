<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'invoice_number',
        'payment_method',
        'order_details_id',
    ];

    // public function orderDetails()
    // {
    //     return $this->belongsTo(OrderDetails::class);
    // }
}
