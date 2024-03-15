<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'fullname',
        'contact',
        'email',
        'address',
        'subtotal',
        'products_ordered',
        'total_amount',
        'total_quantity',
    ];

    // public function order()
    // {
    //     return $this->hasOne(Orders::class);
    // }
}
