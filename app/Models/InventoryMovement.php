<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'type',
        'reference',
        'notes',
        'quantity',
        'unit_cost',
        'total_cost',
        'movement_date',
        'product_id',
        'warehouse_id',
        'user_id',
        'supplier_id',
        'destination_warehouse_id'
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'movement_date' => 'datetime',
        'quantity' => 'integer',
    ];

    // Constantes para tipos de movimiento
    const TYPE_ENTRY = 'entry';
    const TYPE_EXIT = 'exit';
    const TYPE_ADJUSTMENT = 'adjustment';
    const TYPE_TRANSFER = 'transfer';

    // Relaciones
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function destinationWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('movement_date', [$startDate, $endDate]);
    }

    public function scopeEntries($query)
    {
        return $query->where('type', self::TYPE_ENTRY);
    }

    public function scopeExits($query)
    {
        return $query->where('type', self::TYPE_EXIT);
    }

    public function scopeTransfers($query)
    {
        return $query->where('type', self::TYPE_TRANSFER);
    }

    // Accessors
    public function getTypeNameAttribute()
    {
        return match($this->type) {
            self::TYPE_ENTRY => 'Entrada',
            self::TYPE_EXIT => 'Salida',
            self::TYPE_ADJUSTMENT => 'Ajuste',
            self::TYPE_TRANSFER => 'Transferencia',
            default => 'Desconocido'
        };
    }

    public function getIsPositiveAttribute()
    {
        return in_array($this->type, [self::TYPE_ENTRY, self::TYPE_ADJUSTMENT]) && $this->quantity > 0;
    }

    public function getIsNegativeAttribute()
    {
        return in_array($this->type, [self::TYPE_EXIT, self::TYPE_ADJUSTMENT]) && $this->quantity < 0;
    }
}
