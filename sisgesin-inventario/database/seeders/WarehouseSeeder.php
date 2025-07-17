<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Almacén Central',
                'code' => 'AC001',
                'description' => 'Almacén principal de la empresa',
                'address' => 'Av. Principal 123, Ciudad',
                'is_active' => true,
                'is_main' => true
            ],
            [
                'name' => 'Almacén Norte',
                'code' => 'AN002',
                'description' => 'Sucursal zona norte',
                'address' => 'Calle Norte 456, Ciudad',
                'is_active' => true,
                'is_main' => false
            ],
            [
                'name' => 'Almacén Sur',
                'code' => 'AS003',
                'description' => 'Sucursal zona sur',
                'address' => 'Av. Sur 789, Ciudad',
                'is_active' => true,
                'is_main' => false
            ],
        ];

        foreach ($warehouses as $warehouse) {
            $warehouse['slug'] = Str::slug($warehouse['name']);
            Warehouse::create($warehouse);
        }
    }
}
