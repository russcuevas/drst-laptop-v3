<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_picture',
        'product_name',
        'product_price',
        'product_type',
        'product_net_wt',
        'product_grain',
        'product_stocks',
        'product_status',
    ];
}
