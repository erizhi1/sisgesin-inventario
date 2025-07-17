# Documentación de la API - SisgesIn
# Sistema de Gestión de Inventarios

Write-Host "📚 DOCUMENTACIÓN DE LA API - SISGESIN" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan

Write-Host ""
Write-Host "🔗 URL Base: http://127.0.0.1:8000/api" -ForegroundColor Yellow

Write-Host ""
Write-Host "🏷️  ENDPOINTS DE CATEGORÍAS" -ForegroundColor Magenta
Write-Host "GET    /categories" -ForegroundColor Green -NoNewline
Write-Host "                    - Listar todas las categorías" -ForegroundColor White
Write-Host "GET    /categories/tree" -ForegroundColor Green -NoNewline
Write-Host "              - Obtener árbol jerárquico de categorías" -ForegroundColor White
Write-Host "POST   /categories" -ForegroundColor Green -NoNewline
Write-Host "                    - Crear nueva categoría" -ForegroundColor White
Write-Host "GET    /categories/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Obtener categoría específica" -ForegroundColor White
Write-Host "PUT    /categories/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Actualizar categoría" -ForegroundColor White
Write-Host "DELETE /categories/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Eliminar categoría" -ForegroundColor White

Write-Host ""
Write-Host "📦 ENDPOINTS DE PRODUCTOS" -ForegroundColor Magenta
Write-Host "GET    /products" -ForegroundColor Green -NoNewline
Write-Host "                      - Listar todos los productos" -ForegroundColor White
Write-Host "GET    /products/search?q={term}" -ForegroundColor Green -NoNewline
Write-Host "   - Buscar productos por término" -ForegroundColor White
Write-Host "GET    /products/low-stock" -ForegroundColor Green -NoNewline
Write-Host "          - Productos con stock bajo" -ForegroundColor White
Write-Host "POST   /products" -ForegroundColor Green -NoNewline
Write-Host "                      - Crear nuevo producto" -ForegroundColor White
Write-Host "GET    /products/{id}" -ForegroundColor Green -NoNewline
Write-Host "               - Obtener producto específico" -ForegroundColor White
Write-Host "PUT    /products/{id}" -ForegroundColor Green -NoNewline
Write-Host "               - Actualizar producto" -ForegroundColor White
Write-Host "DELETE /products/{id}" -ForegroundColor Green -NoNewline
Write-Host "               - Eliminar producto" -ForegroundColor White

Write-Host ""
Write-Host "📊 ENDPOINTS DE INVENTARIO" -ForegroundColor Magenta
Write-Host "GET    /inventory/current-stock" -ForegroundColor Green -NoNewline
Write-Host "       - Stock actual de todos los productos" -ForegroundColor White
Write-Host "GET    /inventory/movements" -ForegroundColor Green -NoNewline
Write-Host "           - Historial de movimientos" -ForegroundColor White
Write-Host "GET    /inventory/valued-report" -ForegroundColor Green -NoNewline
Write-Host "      - Reporte valorizado del inventario" -ForegroundColor White
Write-Host "GET    /inventory/low-stock" -ForegroundColor Green -NoNewline
Write-Host "          - Productos con stock bajo en inventario" -ForegroundColor White

Write-Host ""
Write-Host "🔄 OPERACIONES DE STOCK" -ForegroundColor Magenta
Write-Host "POST   /inventory/add-stock" -ForegroundColor Green -NoNewline
Write-Host "         - Agregar stock a un producto" -ForegroundColor White
Write-Host "POST   /inventory/remove-stock" -ForegroundColor Green -NoNewline
Write-Host "      - Retirar stock de un producto" -ForegroundColor White
Write-Host "POST   /inventory/transfer-stock" -ForegroundColor Green -NoNewline
Write-Host "    - Transferir stock entre almacenes" -ForegroundColor White
Write-Host "POST   /inventory/adjust-stock" -ForegroundColor Green -NoNewline
Write-Host "      - Ajustar stock (inventario físico)" -ForegroundColor White

Write-Host ""
Write-Host "🏪 ENDPOINTS DE ALMACENES" -ForegroundColor Magenta
Write-Host "GET    /warehouses" -ForegroundColor Green -NoNewline
Write-Host "                    - Listar todos los almacenes" -ForegroundColor White
Write-Host "POST   /warehouses" -ForegroundColor Green -NoNewline
Write-Host "                    - Crear nuevo almacén" -ForegroundColor White
Write-Host "GET    /warehouses/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Obtener almacén específico" -ForegroundColor White
Write-Host "PUT    /warehouses/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Actualizar almacén" -ForegroundColor White
Write-Host "DELETE /warehouses/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Eliminar almacén" -ForegroundColor White

Write-Host ""
Write-Host "🏷️  ENDPOINTS DE MARCAS" -ForegroundColor Magenta
Write-Host "GET    /brands" -ForegroundColor Green -NoNewline
Write-Host "                        - Listar todas las marcas" -ForegroundColor White
Write-Host "POST   /brands" -ForegroundColor Green -NoNewline
Write-Host "                        - Crear nueva marca" -ForegroundColor White
Write-Host "GET    /brands/{id}" -ForegroundColor Green -NoNewline
Write-Host "                 - Obtener marca específica" -ForegroundColor White
Write-Host "PUT    /brands/{id}" -ForegroundColor Green -NoNewline
Write-Host "                 - Actualizar marca" -ForegroundColor White
Write-Host "DELETE /brands/{id}" -ForegroundColor Green -NoNewline
Write-Host "                 - Eliminar marca" -ForegroundColor White

Write-Host ""
Write-Host "🏢 ENDPOINTS DE PROVEEDORES" -ForegroundColor Magenta
Write-Host "GET    /suppliers" -ForegroundColor Green -NoNewline
Write-Host "                    - Listar todos los proveedores" -ForegroundColor White
Write-Host "POST   /suppliers" -ForegroundColor Green -NoNewline
Write-Host "                    - Crear nuevo proveedor" -ForegroundColor White
Write-Host "GET    /suppliers/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Obtener proveedor específico" -ForegroundColor White
Write-Host "PUT    /suppliers/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Actualizar proveedor" -ForegroundColor White
Write-Host "DELETE /suppliers/{id}" -ForegroundColor Green -NoNewline
Write-Host "             - Eliminar proveedor" -ForegroundColor White

Write-Host ""
Write-Host "📋 EJEMPLOS DE USO" -ForegroundColor Yellow
Write-Host "=================" -ForegroundColor Yellow

Write-Host ""
Write-Host "💡 Crear un producto:" -ForegroundColor Cyan
Write-Host @"
{
    "name": "iPhone 15 Pro",
    "sku": "IPH15PRO001",
    "description": "Smartphone Apple iPhone 15 Pro",
    "purchase_price": 750.00,
    "sale_price": 999.99,
    "unit": "unidad",
    "category_id": 1,
    "brand_id": 1,
    "min_stock": 5,
    "is_active": true
}
"@ -ForegroundColor Gray

Write-Host ""
Write-Host "💡 Agregar stock:" -ForegroundColor Cyan
Write-Host @"
{
    "product_id": 1,
    "warehouse_id": 1,
    "quantity": 50,
    "notes": "Entrada de mercancía nueva"
}
"@ -ForegroundColor Gray

Write-Host ""
Write-Host "💡 Transferir stock:" -ForegroundColor Cyan
Write-Host @"
{
    "product_id": 1,
    "source_warehouse_id": 1,
    "destination_warehouse_id": 2,
    "quantity": 10,
    "notes": "Transferencia entre almacenes"
}
"@ -ForegroundColor Gray

Write-Host ""
Write-Host "🔧 HERRAMIENTAS DISPONIBLES" -ForegroundColor Yellow
Write-Host "===========================" -ForegroundColor Yellow
Write-Host "• test_api.ps1           - Pruebas generales del API" -ForegroundColor White
Write-Host "• test_inventory.ps1     - Pruebas específicas de inventario" -ForegroundColor White
Write-Host "• system_summary.ps1     - Resumen completo del sistema" -ForegroundColor White
Write-Host "• api_docs.ps1           - Esta documentación" -ForegroundColor White

Write-Host ""
Write-Host "🌐 INTERFAZ WEB" -ForegroundColor Yellow
Write-Host "===============" -ForegroundColor Yellow
Write-Host "Dashboard: http://127.0.0.1:8000" -ForegroundColor White
Write-Host "API Test:  http://127.0.0.1:8000/api-test" -ForegroundColor White

Write-Host ""
Write-Host "✨ SISTEMA COMPLETAMENTE FUNCIONAL" -ForegroundColor Green
Write-Host "==================================" -ForegroundColor Green
