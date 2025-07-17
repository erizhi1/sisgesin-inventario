<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relaciones
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/brands/' . $this->logo) : null;
    }
}
