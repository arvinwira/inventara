<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku','name','category','unit','cost_price','sell_price','reorder_point'
    ];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'sell_price'    => 'decimal:2',
        'reorder_point' => 'integer',
    ];

    public function movements()
    {
        return $this->hasMany(\App\Models\InventoryMovement::class);
    }

    public function getCurrentStockAttribute(): int
    {
        $in  = $this->movements()
                    ->whereIn('type', ['PURCHASE','ADJUST','RETURN'])
                    ->sum('qty');

        $out = $this->movements()
                    ->where('type', 'SALE')
                    ->sum('qty');

        return (int) ($in - $out);
    }
}
