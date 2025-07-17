<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónicos',
                'description' => 'Productos electrónicos y tecnología',
                'is_active' => true,
                'children' => [
                    ['name' => 'Smartphones', 'description' => 'Teléfonos inteligentes'],
                    ['name' => 'Laptops', 'description' => 'Computadoras portátiles'],
                    ['name' => 'Accesorios', 'description' => 'Accesorios electrónicos'],
                ]
            ],
            [
                'name' => 'Ropa',
                'description' => 'Vestimenta y accesorios',
                'is_active' => true,
                'children' => [
                    ['name' => 'Hombre', 'description' => 'Ropa para hombre'],
                    ['name' => 'Mujer', 'description' => 'Ropa para mujer'],
                    ['name' => 'Niños', 'description' => 'Ropa para niños'],
                ]
            ],
            [
                'name' => 'Hogar',
                'description' => 'Productos para el hogar',
                'is_active' => true,
                'children' => [
                    ['name' => 'Cocina', 'description' => 'Utensilios de cocina'],
                    ['name' => 'Baño', 'description' => 'Productos para el baño'],
                    ['name' => 'Decoración', 'description' => 'Elementos decorativos'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);
            
            $categoryData['slug'] = Str::slug($categoryData['name']);
            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['slug'] = Str::slug($childData['name']);
                $childData['is_active'] = true;
                Category::create($childData);
            }
        }
    }
}
