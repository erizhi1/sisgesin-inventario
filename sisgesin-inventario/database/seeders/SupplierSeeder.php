<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'TechDistribution SA',
                'contact_person' => 'Juan Pérez',
                'phone' => '+1234567890',
                'email' => 'ventas@techdist.com',
                'address' => 'Av. Tecnología 123, Ciudad',
                'tax_id' => '12345678-9',
                'is_active' => true
            ],
            [
                'name' => 'ElectroSupply Ltda',
                'contact_person' => 'María García',
                'phone' => '+1234567891',
                'email' => 'contacto@electrosupply.com',
                'address' => 'Calle Electrónica 456, Ciudad',
                'tax_id' => '98765432-1',
                'is_active' => true
            ],
            [
                'name' => 'MegaProveedor Corp',
                'contact_person' => 'Carlos López',
                'phone' => '+1234567892',
                'email' => 'info@megaproveedor.com',
                'address' => 'Blvd. Comercial 789, Ciudad',
                'tax_id' => '11223344-5',
                'is_active' => true
            ],
        ];

        foreach ($suppliers as $supplier) {
            $supplier['slug'] = Str::slug($supplier['name']);
            Supplier::create($supplier);
        }
    }
}
