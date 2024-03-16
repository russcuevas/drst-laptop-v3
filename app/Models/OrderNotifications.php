<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderNotifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_id',
        'message',
        'is_seen',
        'is_customer_seen'
    ];
}
