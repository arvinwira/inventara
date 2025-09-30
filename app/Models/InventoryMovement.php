<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id',
        'type',    // PURCHASE, SALE, ADJUST, RETURN
        'qty',
        'note'
    ];

    // relasi balik ke produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
