<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'subcategory_id',
        'fabric',
        'min_quantity',
        'max_quantity',
        'price',

    ];
}
