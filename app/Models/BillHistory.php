<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'user_id',
        'disco_id',
        'bill_amount',
        'paid_amount',
        'balance_bfo',
        'balance_aft',
        'meter_number',
        'meter_type',
        'customer_name',
        'customer_address',
        'customer_phone',
        'token',
        'refund',
        'status',
    ];	
}
