<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Samsung', 'description' => 'Tecnología Samsung', 'is_active' => true],
            ['name' => 'Apple', 'description' => 'Productos Apple', 'is_active' => true],
            ['name' => 'Sony', 'description' => 'Electrónicos Sony', 'is_active' => true],
            ['name' => 'Nike', 'description' => 'Ropa deportiva Nike', 'is_active' => true],
            ['name' => 'Adidas', 'description' => 'Ropa deportiva Adidas', 'is_active' => true],
            ['name' => 'HP', 'description' => 'Computadoras HP', 'is_active' => true],
            ['name' => 'Dell', 'description' => 'Computadoras Dell', 'is_active' => true],
            ['name' => 'Lenovo', 'description' => 'Computadoras Lenovo', 'is_active' => true],
        ];

        foreach ($brands as $brand) {
            $brand['slug'] = Str::slug($brand['name']);
            Brand::create($brand);
        }
    }
}
