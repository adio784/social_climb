<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'network_id',
        'plan_id',
        'user_id',
        'data_type',
        'mobile_number',
        'Status',
        'medium',
        'balance_before',
        'balance_after',
        'plan_amount',
        'Ported_number',
        'ident',
        'refund',
        'api_response',
    ];
}
