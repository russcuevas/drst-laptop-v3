<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductNotifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'message',
        'is_seen'
    ];

    protected $table = 'product_notifications'; // Adjust if your table name is different

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Assuming 'product_id' is the foreign key
    }
}
