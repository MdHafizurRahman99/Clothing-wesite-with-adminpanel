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
        'display_name',
        'size',
        'customcolor',
        'minimum_order',
        'minimum_time_required',
        'product_for',
        'pattern_id',
        'productsizetype',
        'weight',
        'gender',
        'category_id',
        'image',
        'design_image_front_side',
        'design_image_back_side',
        'design_image_right_side',
        'design_image_left_side',
        'price',
        'description',
    ];

    public function sizeDetails()
    {
        return $this->hasMany(ProductSizeDetail::class);
    }

    public function colors() {
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id');
    }

       public function sleeveConfigs()
    {
        return $this->hasMany(sleeve_config::class);
    }

}
