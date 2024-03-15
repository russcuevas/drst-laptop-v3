<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInitialStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'initial_status',
        'status_id',
        'placed_at',
        'on_process_at',
        'on_the_way_at',
        'delivered_at',
    ];
}
