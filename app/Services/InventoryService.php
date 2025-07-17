<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Stock;
use App\Models\InventoryMovement;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryService
{
    /**
     * Registrar entrada de mercancía
     */
    public function addStock(array $data): InventoryMovement
    {
        return DB::transaction(function () use ($data) {
            // Crear movimiento
            $movement = InventoryMovement::create([
                'type' => InventoryMovement::TYPE_ENTRY,
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
                'quantity' => $data['quantity'],
                'unit_cost' => $data['unit_cost'] ?? null,
                'total_cost' => isset($data['unit_cost']) ? $data['unit_cost'] * $data['quantity'] : null,
                'movement_date' => $data['movement_date'] ?? now(),
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['warehouse_id'],
                'user_id' => Auth::id() ?? 1 ?? 1, // Usuario por defecto si no hay autenticación
                'supplier_id' => $data['supplier_id'] ?? null,
            ]);

            // Actualizar stock
            $this->updateStock($data['product_id'], $data['warehouse_id'], $data['quantity']);

            return $movement;
        });
    }

    /**
     * Registrar salida de mercancía
     */
    public function removeStock(array $data): InventoryMovement
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);
            $warehouse = Warehouse::findOrFail($data['warehouse_id']);

            // Verificar stock disponible
            $stock = Stock::where('product_id', $data['product_id'])
                         ->where('warehouse_id', $data['warehouse_id'])
                         ->first();

            if (!$stock || $stock->available_quantity < $data['quantity']) {
                throw new \Exception("Stock insuficiente para el producto {$product->name} en almacén {$warehouse->name}");
            }

            // Crear movimiento
            $movement = InventoryMovement::create([
                'type' => InventoryMovement::TYPE_EXIT,
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
                'quantity' => -$data['quantity'], // Negativo para salidas
                'unit_cost' => $data['unit_cost'] ?? null,
                'total_cost' => isset($data['unit_cost']) ? $data['unit_cost'] * $data['quantity'] : null,
                'movement_date' => $data['movement_date'] ?? now(),
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['warehouse_id'],
                'user_id' => Auth::id() ?? 1 ?? 1, // Usuario por defecto si no hay autenticación
            ]);

            // Actualizar stock
            $this->updateStock($data['product_id'], $data['warehouse_id'], -$data['quantity']);

            return $movement;
        });
    }

    /**
     * Transferir stock entre almacenes
     */
    public function transferStock(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);
            $sourceWarehouse = Warehouse::findOrFail($data['source_warehouse_id']);
            $destinationWarehouse = Warehouse::findOrFail($data['destination_warehouse_id']);

            // Verificar stock disponible en origen
            $sourceStock = Stock::where('product_id', $data['product_id'])
                                ->where('warehouse_id', $data['source_warehouse_id'])
                                ->first();

            if (!$sourceStock || $sourceStock->available_quantity < $data['quantity']) {
                throw new \Exception("Stock insuficiente en el almacén de origen {$sourceWarehouse->name}");
            }

            // Movimiento de salida del almacén origen
            $exitMovement = InventoryMovement::create([
                'type' => InventoryMovement::TYPE_TRANSFER,
                'reference' => $data['reference'] ?? "TRANS-" . now()->format('YmdHis'),
                'notes' => $data['notes'] ?? "Transferencia a {$destinationWarehouse->name}",
                'quantity' => -$data['quantity'],
                'movement_date' => $data['movement_date'] ?? now(),
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['source_warehouse_id'],
                'destination_warehouse_id' => $data['destination_warehouse_id'],
                'user_id' => Auth::id() ?? 1,
            ]);

            // Movimiento de entrada al almacén destino
            $entryMovement = InventoryMovement::create([
                'type' => InventoryMovement::TYPE_TRANSFER,
                'reference' => $exitMovement->reference,
                'notes' => $data['notes'] ?? "Transferencia desde {$sourceWarehouse->name}",
                'quantity' => $data['quantity'],
                'movement_date' => $data['movement_date'] ?? now(),
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['destination_warehouse_id'],
                'destination_warehouse_id' => $data['source_warehouse_id'],
                'user_id' => Auth::id() ?? 1,
            ]);

            // Actualizar stocks
            $this->updateStock($data['product_id'], $data['source_warehouse_id'], -$data['quantity']);
            $this->updateStock($data['product_id'], $data['destination_warehouse_id'], $data['quantity']);

            return [
                'exit_movement' => $exitMovement,
                'entry_movement' => $entryMovement
            ];
        });
    }

    /**
     * Realizar ajuste de inventario
     */
    public function adjustStock(array $data): InventoryMovement
    {
        return DB::transaction(function () use ($data) {
            $stock = Stock::where('product_id', $data['product_id'])
                         ->where('warehouse_id', $data['warehouse_id'])
                         ->first();

            $currentQuantity = $stock ? $stock->quantity : 0;
            $newQuantity = $data['new_quantity'];
            $adjustment = $newQuantity - $currentQuantity;

            if ($adjustment == 0) {
                throw new \Exception('No hay diferencia en el stock actual');
            }

            // Crear movimiento de ajuste
            $movement = InventoryMovement::create([
                'type' => InventoryMovement::TYPE_ADJUSTMENT,
                'reference' => $data['reference'] ?? "ADJ-" . now()->format('YmdHis'),
                'notes' => $data['notes'] ?? "Ajuste de inventario",
                'quantity' => $adjustment,
                'movement_date' => $data['movement_date'] ?? now(),
                'product_id' => $data['product_id'],
                'warehouse_id' => $data['warehouse_id'],
                'user_id' => Auth::id() ?? 1,
            ]);

            // Actualizar stock al valor exacto
            $this->setStock($data['product_id'], $data['warehouse_id'], $newQuantity);

            return $movement;
        });
    }

    /**
     * Actualizar stock (incrementar/decrementar)
     */
    private function updateStock(int $productId, int $warehouseId, int $quantity): Stock
    {
        $stock = Stock::firstOrCreate(
            [
                'product_id' => $productId,
                'warehouse_id' => $warehouseId
            ],
            [
                'quantity' => 0,
                'reserved_quantity' => 0
            ]
        );

        $stock->increment('quantity', $quantity);
        
        // Corrección automática de saldos negativos
        if ($stock->fresh()->quantity < 0) {
            $this->correctNegativeStock($productId, $warehouseId);
        }

        return $stock->fresh();
    }

    /**
     * Establecer stock a un valor específico
     */
    private function setStock(int $productId, int $warehouseId, int $quantity): Stock
    {
        $stock = Stock::firstOrCreate(
            [
                'product_id' => $productId,
                'warehouse_id' => $warehouseId
            ],
            [
                'quantity' => $quantity,
                'reserved_quantity' => 0
            ]
        );

        $stock->update(['quantity' => $quantity]);

        return $stock;
    }

    /**
     * Corrección automática de saldos negativos
     */
    private function correctNegativeStock(int $productId, int $warehouseId): void
    {
        $stock = Stock::where('product_id', $productId)
                     ->where('warehouse_id', $warehouseId)
                     ->first();

        if ($stock && $stock->quantity < 0) {
            // Registrar ajuste automático
            InventoryMovement::create([
                'type' => InventoryMovement::TYPE_ADJUSTMENT,
                'reference' => "AUTO-CORRECT-" . now()->format('YmdHis'),
                'notes' => "Corrección automática de saldo negativo",
                'quantity' => -$stock->quantity, // Cantidad necesaria para llegar a 0
                'movement_date' => now(),
                'product_id' => $productId,
                'warehouse_id' => $warehouseId,
                'user_id' => 1, // Sistema
            ]);

            // Corregir a 0
            $stock->update(['quantity' => 0]);
        }
    }

    /**
     * Obtener resumen de stock por producto
     */
    public function getStockSummary(int $productId): array
    {
        $stocks = Stock::with('warehouse')
                      ->where('product_id', $productId)
                      ->get();

        return [
            'total_quantity' => $stocks->sum('quantity'),
            'total_reserved' => $stocks->sum('reserved_quantity'),
            'total_available' => $stocks->sum('available_quantity'),
            'warehouses' => $stocks->map(function ($stock) {
                return [
                    'warehouse_id' => $stock->warehouse_id,
                    'warehouse_name' => $stock->warehouse->name,
                    'quantity' => $stock->quantity,
                    'reserved_quantity' => $stock->reserved_quantity,
                    'available_quantity' => $stock->available_quantity,
                ];
            })
        ];
    }

    /**
     * Obtener productos con stock bajo
     */
    public function getLowStockProducts(int $warehouseId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Product::with(['category', 'stocks.warehouse'])
                        ->lowStock($warehouseId);

        return $query->get();
    }

    /**
     * Reservar stock para una venta
     */
    public function reserveStock(int $productId, int $warehouseId, int $quantity): bool
    {
        $stock = Stock::where('product_id', $productId)
                     ->where('warehouse_id', $warehouseId)
                     ->first();

        return $stock ? $stock->reserve($quantity) : false;
    }

    /**
     * Liberar stock reservado
     */
    public function unreserveStock(int $productId, int $warehouseId, int $quantity): void
    {
        $stock = Stock::where('product_id', $productId)
                     ->where('warehouse_id', $warehouseId)
                     ->first();

        if ($stock) {
            $stock->unreserve($quantity);
        }
    }
}
