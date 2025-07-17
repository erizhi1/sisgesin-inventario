<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Listar categorías
     */
    public function index(Request $request): JsonResponse
    {
        $query = Category::with(['parent', 'children'])->withCount('products');

        // Filtros
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->has('parent_only')) {
            $query->parents();
        }

        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->get('parent_id'));
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación o toda la lista
        if ($request->has('all')) {
            $categories = $query->get();
        } else {
            $perPage = $request->get('per_page', 15);
            $categories = $query->paginate($perPage);
        }

        return response()->json($categories);
    }

    /**
     * Crear nueva categoría
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);
        $category->load(['parent', 'children']);

        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'data' => $category
        ], 201);
    }

    /**
     * Mostrar categoría específica
     */
    public function show(Category $category): JsonResponse
    {
        $category->load(['parent', 'children', 'products']);
        $category->loadCount('products');

        return response()->json([
            'data' => $category
        ]);
    }

    /**
     * Actualizar categoría
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    // No puede ser padre de sí misma
                    if ($value == $category->id) {
                        $fail('Una categoría no puede ser padre de sí misma');
                    }
                    
                    // No puede ser padre de sus propios hijos (evitar ciclos)
                    if ($value && $category->children()->where('id', $value)->exists()) {
                        $fail('No se pueden crear relaciones circulares entre categorías');
                    }
                }
            ],
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);
        $category->load(['parent', 'children']);

        return response()->json([
            'message' => 'Categoría actualizada exitosamente',
            'data' => $category
        ]);
    }

    /**
     * Eliminar categoría
     */
    public function destroy(Category $category): JsonResponse
    {
        // Verificar si tiene productos asociados
        if ($category->products()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar la categoría porque tiene productos asociados'
            ], 400);
        }

        // Verificar si tiene categorías hijas
        if ($category->children()->exists()) {
            return response()->json([
                'message' => 'No se puede eliminar la categoría porque tiene subcategorías asociadas'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'message' => 'Categoría eliminada exitosamente'
        ]);
    }

    /**
     * Obtener árbol de categorías
     */
    public function tree(Request $request): JsonResponse
    {
        $categories = Category::with(['children' => function ($query) {
            $query->active()->with(['children' => function ($subQuery) {
                $subQuery->active();
            }]);
        }])
        ->parents()
        ->active()
        ->orderBy('name')
        ->get();

        return response()->json([
            'data' => $categories
        ]);
    }

    /**
     * Buscar categorías
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:1'
        ]);

        $query = $request->get('q');
        $limit = $request->get('limit', 10);

        $categories = Category::where('name', 'like', "%{$query}%")
            ->active()
            ->limit($limit)
            ->get();

        return response()->json([
            'data' => $categories
        ]);
    }
}
