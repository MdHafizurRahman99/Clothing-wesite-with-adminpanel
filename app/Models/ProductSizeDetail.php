<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeDetail extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'size', 'height', 'weight'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
