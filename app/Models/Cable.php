<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cable extends Model
{
    use HasFactory;

    protected $fillable = ['cable_id', 'plan_name', 'plan_code', 'plan_amount', 'is_active'];
}
