<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'order_id', 'link', 'service', 'quantity', 'product_price', 'balance_before', 'balance_after', 'status'];
}
