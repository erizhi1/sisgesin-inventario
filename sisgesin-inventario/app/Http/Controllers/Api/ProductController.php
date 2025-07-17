<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Listar productos con filtros y paginación
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'brand', 'supplier', 'stocks.warehouse']);

        // Filtros
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->get('brand_id'));
        }

        if ($request->has('supplier_id')) {
            $query->where('supplier_id', $request->get('supplier_id'));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('low_stock')) {
            $warehouseId = $request->get('warehouse_id');
            $query->lowStock($warehouseId);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        // Agregar información de stock
        $products->getCollection()->transform(function ($product) {
            $product->stock_summary = $this->inventoryService->getStockSummary($product->id);
            return $product;
        });

        return response()->json($products);
    }

    /**
     * Crear nuevo producto
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products',
            'barcode' => 'nullable|string|max:100|unique:products',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'min_stock' => 'integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:20',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'is_active' => 'boolean',
            'track_stock' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product = Product::create($validated);
        $product->load(['category', 'brand', 'supplier']);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'data' => $product
        ], 201);
    }

    /**
     * Mostrar producto específico
     */
    public function show(Product $product): JsonResponse
    {
        $product->load(['category', 'brand', 'supplier', 'stocks.warehouse']);
        $product->stock_summary = $this->inventoryService->getStockSummary($product->id);

        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Actualizar producto
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => ['required', 'string', 'max:100', Rule::unique('products')->ignore($product->id)],
            'barcode' => ['nullable', 'string', 'max:100', Rule::unique('products')->ignore($product->id)],
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'min_stock' => 'integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:20',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'is_active' => 'boolean',
            'track_stock' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);
        $product->load(['category', 'brand', 'supplier']);

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'data' => $product
        ]);
    }

    /**
     * Eliminar producto
     */
    public function destroy(Product $product): JsonResponse
    {
        // Verificar si tiene movimientos de inventario
        if ($product->inventoryMovements()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar el producto porque tiene movimientos de inventario asociados'
            ], 400);
        }

        // Eliminar stocks asociados
        $product->stocks()->delete();
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente'
        ]);
    }

    /**
     * Buscar productos por texto
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:1'
        ]);

        $query = $request->get('q');
        $limit = $request->get('limit', 10);

        $products = Product::with(['category', 'brand'])
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%")
                  ->orWhere('barcode', 'like', "%{$query}%");
            })
            ->active()
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $products
        ]);
    }

    /**
     * Obtener stock de producto por almacén
     */
    public function stock(Product $product): JsonResponse
    {
        $stockSummary = $this->inventoryService->getStockSummary($product->id);

        return response()->json([
            'data' => $stockSummary
        ]);
    }

    /**
     * Productos con stock bajo
     */
    public function lowStock(Request $request): JsonResponse
    {
        $warehouseId = $request->get('warehouse_id');
        $products = $this->inventoryService->getLowStockProducts($warehouseId);

        return response()->json([
            'data' => $products
        ]);
    }
}
