<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDesign extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'neck_level',
        'neck_level_details',
        'neck_level_design',
        'right_sleeve',
        'right_sleeve_details',
        'right_sleeve_design',
        'left_sleeve',
        'left_sleeve_details',
        'left_sleeve_design',
        'design_details',
        'swing_tag',
        'custom_color',
        'swing_tag_details',
        'swing_tag_design',
        // 'product_id',
        // 'design_details',
        // 'neck_level',
        // 'neck_level_details',
        // 'swing_tag',
        // 'swing_tag_details',
    ];
}
