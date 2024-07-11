<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirtimeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'network_id',
        'mobile_number',
        'cost_price',
        'amount_paid',
        'airtime_type',
        'reference',
        'status',
        'medium',
        'balance_before',
        'balance_after',
        'ported_number',
        'refunded',
        'api_response',
    ];
}
