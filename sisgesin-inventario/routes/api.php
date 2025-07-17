<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\InventoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas de productos
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/search', [ProductController::class, 'search']);
    Route::get('/low-stock', [ProductController::class, 'lowStock']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
    Route::get('/{product}/stock', [ProductController::class, 'stock']);
});

// Rutas de categorías
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/tree', [CategoryController::class, 'tree']);
    Route::get('/search', [CategoryController::class, 'search']);
    Route::get('/{category}', [CategoryController::class, 'show']);
    Route::put('/{category}', [CategoryController::class, 'update']);
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

// Rutas de inventario
Route::prefix('inventory')->group(function () {
    // Movimientos
    Route::get('/movements', [InventoryController::class, 'movements']);
    
    // Operaciones de stock
    Route::post('/add-stock', [InventoryController::class, 'addStock']);
    Route::post('/remove-stock', [InventoryController::class, 'removeStock']);
    Route::post('/transfer-stock', [InventoryController::class, 'transferStock']);
    Route::post('/adjust-stock', [InventoryController::class, 'adjustStock']);
    
    // Consultas
    Route::get('/current-stock', [InventoryController::class, 'currentStock']);
    Route::get('/low-stock', [InventoryController::class, 'lowStock']);
    Route::get('/valued-report', [InventoryController::class, 'valuedReport']);
    Route::get('/product-history/{product}', [InventoryController::class, 'productHistory']);
});
