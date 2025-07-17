<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'purchase_price',
        'sale_price',
        'min_stock',
        'max_stock',
        'unit',
        'images',
        'is_active',
        'track_stock',
        'category_id',
        'brand_id',
        'supplier_id'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean',
        'track_stock' => 'boolean',
    ];

    // Relaciones
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query, $warehouseId = null)
    {
        return $query->whereHas('stocks', function ($query) use ($warehouseId) {
            $query->whereRaw('quantity <= products.min_stock');
            if ($warehouseId) {
                $query->where('warehouse_id', $warehouseId);
            }
        });
    }

    // Accessors
    public function getTotalStockAttribute()
    {
        return $this->stocks->sum('quantity');
    }

    public function getAvailableStockAttribute()
    {
        return $this->stocks->sum('available_quantity');
    }

    public function getMainImageAttribute()
    {
        $images = $this->images ?? [];
        return count($images) > 0 ? asset('storage/products/' . $images[0]) : null;
    }

    // Métodos de utilidad
    public function getStockByWarehouse($warehouseId)
    {
        return $this->stocks()->where('warehouse_id', $warehouseId)->first();
    }

    public function hasStock($warehouseId = null, $quantity = 1)
    {
        if ($warehouseId) {
            $stock = $this->getStockByWarehouse($warehouseId);
            return $stock && $stock->available_quantity >= $quantity;
        }
        
        return $this->available_stock >= $quantity;
    }
}
