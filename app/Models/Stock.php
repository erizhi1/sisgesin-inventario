<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'reserved_quantity'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reserved_quantity' => 'integer',
    ];

    // Relaciones
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Accessors
    public function getAvailableQuantityAttribute()
    {
        return $this->quantity - $this->reserved_quantity;
    }

    // Métodos de utilidad
    public function canReserve($quantity)
    {
        return $this->available_quantity >= $quantity;
    }

    public function reserve($quantity)
    {
        if ($this->canReserve($quantity)) {
            $this->increment('reserved_quantity', $quantity);
            return true;
        }
        return false;
    }

    public function unreserve($quantity)
    {
        $this->decrement('reserved_quantity', min($quantity, $this->reserved_quantity));
    }
}
