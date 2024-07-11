<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'disco_id',
        'plan_name',
        'plan_code',
        'plan_amount',
        'is_active',
    ];
}
