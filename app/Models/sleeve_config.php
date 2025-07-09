<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sleeve_config extends Model
{
    protected $fillable = [
        'product_id',
        'left_image_left',
        'left_image_rotate',
        'sleeve_top',
        'left_image_right',
        'left_image_right_rotate',
        'right_image_left',
        'right_image_rotate',
        'right_image_right',
        'right_image_right_rotate',
    ];

    protected $casts = [
        'left_image_left' => 'float',
        'left_image_rotate' => 'float',
        'sleeve_top' => 'float',
        'left_image_right' => 'float',
        'left_image_right_rotate' => 'float',
        'right_image_left' => 'float',
        'right_image_rotate' => 'float',
        'right_image_right' => 'float',
        'right_image_right_rotate' => 'float',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
