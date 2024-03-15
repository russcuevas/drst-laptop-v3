<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'invoice_number',
        'payment_method',
        'fullname',
        'contact',
        'email',
        'address',
        'products_ordered',
        'total_amount',
        'status',
        'ordered_date',
        'receiving_date',
    ];
}
