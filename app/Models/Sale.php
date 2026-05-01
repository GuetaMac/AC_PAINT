<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {
    protected $fillable = [
        'reference_no', 'customer_name', 'payment_method',
        'total_amount', 'amount_tendered', 'change_amount',
        'status', 'user_id'
    ];

    public function items() {
        return $this->hasMany(SaleItem::class);
    }



    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function generateReference(): string
    {
        $last = self::latest('id')->first();
        $next = $last ? ($last->id + 1) : 1;
        return 'TXN-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function user() {
    return $this->belongsTo(\App\Models\User::class);
}



}