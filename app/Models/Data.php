<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $fillable = ['network', 'plan_size', 'plan_measure', 'plan_price', 'plan_category', 'plan_validity', 'ussd_string', 'sms_message', 'vtpass_planid'];
}
