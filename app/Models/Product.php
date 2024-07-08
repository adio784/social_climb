<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'name', 'category', 'product_rate', 'min', 'max', 'product_type', 'description', 'dripfeed', 'refill', 'is_active'];
}
