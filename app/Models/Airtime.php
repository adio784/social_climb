<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'network_id',
        'cost_perc',
        'percentage',
        'share_shell_perc',
        'is_active',
    ];
}
