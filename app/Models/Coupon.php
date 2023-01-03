<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'coupon_id',
        'coupon_name',
        'currency',
        'precent',
        'promo_id',
        'code',
        'max'
    ];
}
