<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CableHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'user_id',
        'cable_id',
        'plan_id',
        'plan_amount',
        'smart_card_number',
        'balance_before',
        'balance_after',
        'customer_name',
        'refund',
        'status',
    ];
}
