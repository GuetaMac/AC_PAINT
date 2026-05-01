<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model {
    protected $fillable = [
        'sale_id', 'product_id', 'quantity', 'unit_price', 'subtotal'
    ];
public function product() {
    return $this->belongsTo(\App\Models\Product::class);
   }
   // app/Models/SaleItem.php

public function sale()
{
    return $this->belongsTo(Sale::class);
}


}
