<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'user_id',
    //     'name',
    //     'company_name',
    //     'email',
    //     'phone',
    //     'clothing_type',
    //     'specific_preferences',
    // ];
    protected $fillable = [
                'user_id',
        'target',
        'category',
        'subcategory',
        'looking_for',
        'additional_services',
        'number_of_products',
        'quantity_per_model',
        'project_budget',
        'sample_delivery_date',
        'production_delivery_date',
        'project_description',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
