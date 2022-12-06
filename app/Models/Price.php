<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_id',
        'stripe_id',
        'price',
        'currency',
        'is_active',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'stripe_id', 'stripe_id');
    }

    public function payment(){
        return $this->hasOne(PaymentLink::class, 'price_id', 'price_id');
    }
}
