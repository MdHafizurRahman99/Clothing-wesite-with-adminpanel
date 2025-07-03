<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockupDesign extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'side',
        'mockup_image_url',
        'design_images',
        'objects',
    ];
       /**
     * Cast attributes to specific types.
     *
     * @var array
     */
    protected $casts = [
        'design_images' => 'array', // Automatically handles JSON encoding/decoding
        'objects' => 'array',       // Automatically handles JSON encoding/decoding
    ];

}
