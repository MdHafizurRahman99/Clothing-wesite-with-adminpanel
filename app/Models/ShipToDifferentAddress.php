<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipToDifferentAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        "order_id",
        'first_name',
        'last_name',
        'company_name',
        'email',
        'mobile',
        'address',
        'country',
        'city',
        'state',
        'zip_code',
    ];
}
