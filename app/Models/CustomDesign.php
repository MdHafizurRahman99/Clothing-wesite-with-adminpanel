<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDesign extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'design_details',
        'neck_level',
        'neck_level_details',
        'swing_tag',
        'swing_tag_details',
    ];
}
