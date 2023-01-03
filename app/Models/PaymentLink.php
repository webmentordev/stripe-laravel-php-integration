<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_id',
        'quantity',
        'url',
        'promotion_code'
    ];

    public function price(){
        return $this->belongsTo(Price::class, 'price_id', 'price_id');
    }
}