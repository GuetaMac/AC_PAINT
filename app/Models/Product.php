<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
    'product_code', 'name', 'brand', 'category',
    'size', 'price', 'stock', 'min_stock', 'supplier'
];
}