<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stripe_id',
        'is_active',
    ];

    public function prices(){
        return $this->hasMany(Price::class, 'stripe_id', 'stripe_id');
    }
}
