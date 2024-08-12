<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrderImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'custom_order_id',
        'image_url',
    ];
}
