<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price_id',
        'name',
        'email',
        'customer_id',
        'invoice_id',
        'currency',
        'expire',
        'price',
        'url',
        'resends'
    ];
}
