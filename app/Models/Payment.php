<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'customer_email',
        'payment_method',
    ];
}
