<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtItem extends Model
{
    protected $fillable = [
        'debt_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'subtotal',
        'is_paid',
    ];

    protected $casts = [
        'is_paid'    => 'boolean',
        'unit_price' => 'float',
        'subtotal'   => 'float',
    ];

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}