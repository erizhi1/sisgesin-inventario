<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'address',
        'is_active',
        'is_main'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_main' => 'boolean',
    ];

    // Relaciones
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function transfersFrom(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'warehouse_id')->where('type', 'transfer');
    }

    public function transfersTo(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'destination_warehouse_id')->where('type', 'transfer');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }
}
