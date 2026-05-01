<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'debtor_name',
        'total_amount',
        'amount_paid',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'float',
        'amount_paid'  => 'float',
    ];

    public function items()
    {
        return $this->hasMany(DebtItem::class);
    }

    public function getRemainingAttribute(): float
    {
        return max(0, $this->total_amount - $this->amount_paid);
    }

    public function getProgressPctAttribute(): float
    {
        if ($this->total_amount <= 0) return 0;
        return min(100, ($this->amount_paid / $this->total_amount) * 100);
    }
}