<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'value',
        'type',
        'description',
        'usage_limit',
        'min_amount',
        'max_amount'
    ];
}
