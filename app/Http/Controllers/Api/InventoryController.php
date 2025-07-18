<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Listar movimientos de inventario
     */
    public function movements(Request $request): JsonResponse
    {
        $query = InventoryMovement::with(['product', 'warehouse', 'user']);

        // Filtros
        if ($request->has('product_id')) {
            $query->where('product_id', $request->get('product_id'));
        }

        if ($request->has('warehouse_id')) {
            $query->where('warehouse_id', $request->get('warehouse_id'));
        }

        if ($request->has('movement_type')) {
            $query->where('movement_type', $request->get('movement_type'));
        }

        if ($request->has('date_from')) {
            $query->where('created_at', '>=', Carbon::parse($request->get('date_from')));
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', Carbon::parse($request->get('date_to')));
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 15);
        $movements = $query->paginate($perPage);

        return response()->json($movements);
    }

    /**
     * Agregar stock (entrada)
     */
    public function addStock(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit_cost' => 'nullable|numeric|min:0',
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'supplier_id' => 'nullable|exists:suppliers,id'
        ]);

        try {
            $movement = $this->inventoryService->addStock($validated);

            return response()->json([
                'message' => 'Stock agregado exitosamente',
                'data' => $movement->load(['product', 'warehouse'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al agregar stock: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Retirar stock (salida)
     */
    public function removeStock(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit_cost' => 'nullable|numeric|min:0',
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);

        try {
            $movement = $this->inventoryService->removeStock($validated);

            return response()->json([
                'message' => 'Stock retirado exitosamente',
                'data' => $movement->load(['product', 'warehouse'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al retirar stock: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Transferir stock entre almacenes
     */
    public function transferStock(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'source_warehouse_id' => 'required|exists:warehouses,id',
            'destination_warehouse_id' => 'required|exists:warehouses,id|different:source_warehouse_id',
            'quantity' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);

        try {
            $movements = $this->inventoryService->transferStock($validated);

            return response()->json([
                'message' => 'Transferencia realizada exitosamente',
                'data' => [
                    'exit_movement' => $movements['exit_movement']->load(['product', 'warehouse']),
                    'entry_movement' => $movements['entry_movement']->load(['product', 'warehouse'])
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en la transferencia: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Ajustar stock (corrección)
     */
    public function adjustStock(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'new_quantity' => 'required|numeric|min:0',
            'reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string'
        ]);

        try {
            $movement = $this->inventoryService->adjustStock($validated);

            return response()->json([
                'message' => 'Ajuste de stock realizado exitosamente',
                'data' => $movement->load(['product', 'warehouse'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al ajustar stock: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Obtener stock actual por producto y almacén
     */
    public function currentStock(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'warehouse_id' => 'nullable|exists:warehouses,id'
        ]);

        $query = DB::table('stocks')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->join('warehouses', 'stocks.warehouse_id', '=', 'warehouses.id')
            ->select([
                'stocks.*',
                'products.name as product_name',
                'products.sku',
                'warehouses.name as warehouse_name'
            ]);

        if (isset($validated['product_id'])) {
            $query->where('stocks.product_id', $validated['product_id']);
        }

        if (isset($validated['warehouse_id'])) {
            $query->where('stocks.warehouse_id', $validated['warehouse_id']);
        }

        $stocks = $query->get();

        return response()->json([
            'data' => $stocks
        ]);
    }

    /**
     * Productos con stock bajo
     */
    public function lowStock(Request $request): JsonResponse
    {
        $warehouseId = $request->get('warehouse_id');

        try {
            $lowStockProducts = $this->inventoryService->getLowStockProducts($warehouseId);

            return response()->json([
                'data' => $lowStockProducts
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener productos con stock bajo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reporte de inventario valorizado
     */
    public function valuedReport(Request $request): JsonResponse
    {
        $warehouseId = $request->get('warehouse_id');

        $query = DB::table('stocks')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->join('warehouses', 'stocks.warehouse_id', '=', 'warehouses.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'stocks.product_id',
                'stocks.warehouse_id',
                'stocks.quantity',
                'products.purchase_price',
                'products.name as product_name',
                'products.sku',
                'warehouses.name as warehouse_name',
                'categories.name as category_name',
                DB::raw('stocks.quantity * products.purchase_price as total_value')
            ])
            ->where('stocks.quantity', '>', 0);

        if ($warehouseId) {
            $query->where('stocks.warehouse_id', $warehouseId);
        }

        $inventory = $query->get();

        $totalValue = $inventory->sum('total_value');

        return response()->json([
            'data' => $inventory,
            'summary' => [
                'total_products' => $inventory->count(),
                'total_value' => $totalValue
            ]
        ]);
    }

    /**
     * Historial de movimientos por producto
     */
    public function productHistory(Product $product, Request $request): JsonResponse
    {
        $warehouseId = $request->get('warehouse_id');
        $limit = $request->get('limit', 50);

        $query = InventoryMovement::with(['warehouse', 'user'])
            ->where('product_id', $product->id);

        if ($warehouseId) {
            $query->where('warehouse_id', $warehouseId);
        }

        $movements = $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'product' => $product,
            'movements' => $movements
        ]);
    }
}
