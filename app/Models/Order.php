<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'order_date',
        'total_price',
        'sub_total',
        'payment_status',// processing, shipped, delivered
        'order_status',
        'delivery_option_id',
    ];
}
