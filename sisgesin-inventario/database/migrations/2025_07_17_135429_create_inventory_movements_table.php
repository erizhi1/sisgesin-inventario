<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // entry, exit, adjustment, transfer
            $table->string('reference')->nullable(); // Número de factura, orden, etc.
            $table->text('notes')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->timestamp('movement_date');
            
            // Foreign keys
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            
            // Para transferencias
            $table->foreignId('destination_warehouse_id')->nullable()->constrained('warehouses')->onDelete('set null');
            
            $table->timestamps();
            
            $table->index(['type', 'movement_date']);
            $table->index(['product_id', 'warehouse_id', 'movement_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
