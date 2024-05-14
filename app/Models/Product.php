<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // Specify custom primary key field
    public $incrementing = false; // Ensure primary key is not auto-incrementing

    protected $fillable = [
        'id',
        'name',
        'product_for',
        'pattern_id',
        'productsizetype',
        'weight',
        'gender',
        'category_id',
        'image',
        'price',
        'description',
    ];
}
