<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_name',
        'mobile',
        'fax',
        'billing_address1',
        'billing_address2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'same_as_billing',
        'shipping_address1',
        'shipping_address2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
        'primary_payment_method',
        'terms',
        'discount',
        'customer_type',
    ];
}
