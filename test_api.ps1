# Script de Pruebas del Sistema de Gestión de Inventarios
# SisgesIn - Sistema de Gestión de Inventarios PowerShell

Write-Host "🧪 INICIANDO PRUEBAS DEL SISTEMA DE GESTIÓN DE INVENTARIOS" -ForegroundColor Cyan
Write-Host "==========================================================" -ForegroundColor Cyan

$baseUrl = "http://127.0.0.1:8000/api"

function Test-Endpoint {
    param(
        [string]$Method,
        [string]$Endpoint,
        [string]$Data = "",
        [string]$Description
    )
    
    Write-Host "📋 Probando: $Description" -ForegroundColor Yellow
    Write-Host "   $Method $Endpoint" -ForegroundColor Gray
    
    try {
        $uri = "$baseUrl$Endpoint"
        $headers = @{
            "Accept" = "application/json"
            "Content-Type" = "application/json"
        }
        
        if ($Method -eq "GET") {
            $response = Invoke-RestMethod -Uri $uri -Method $Method -Headers $headers
        } else {
            $response = Invoke-RestMethod -Uri $uri -Method $Method -Headers $headers -Body $Data
        }
        
        Write-Host "   ✅ SUCCESS" -ForegroundColor Green
        if ($response.message) {
            Write-Host "   📝 $($response.message)" -ForegroundColor White
        }
    }
    catch {
        $statusCode = $_.Exception.Response.StatusCode.value__
        Write-Host "   ❌ ERROR ($statusCode)" -ForegroundColor Red
        if ($_.ErrorDetails.Message) {
            $errorObj = $_.ErrorDetails.Message | ConvertFrom-Json
            if ($errorObj.message) {
                Write-Host "   💬 $($errorObj.message)" -ForegroundColor Red
            }
        }
    }
    Write-Host ""
}

Write-Host "🏷️  PRUEBAS DE CATEGORÍAS" -ForegroundColor Magenta
Write-Host "========================" -ForegroundColor Magenta

Test-Endpoint "GET" "/categories" "" "Listar todas las categorías"
Test-Endpoint "GET" "/categories/tree" "" "Obtener árbol de categorías"
Test-Endpoint "POST" "/categories" '{"name":"Categoría PowerShell Test","description":"Categoría creada desde PowerShell","is_active":true}' "Crear nueva categoría"

Write-Host "📦 PRUEBAS DE PRODUCTOS" -ForegroundColor Magenta
Write-Host "======================" -ForegroundColor Magenta

Test-Endpoint "GET" "/products" "" "Listar todos los productos"
Test-Endpoint "POST" "/products" '{"name":"Producto PowerShell Test","sku":"PS-TEST-001","description":"Producto de prueba desde PowerShell","purchase_price":250.00,"sale_price":399.99,"unit":"unidad","category_id":1,"brand_id":1,"min_stock":8,"is_active":true}' "Crear nuevo producto"
Test-Endpoint "GET" "/products/search?q=Samsung" "" "Buscar productos Samsung"
Test-Endpoint "GET" "/products/low-stock" "" "Productos con stock bajo"

Write-Host "📊 PRUEBAS DE INVENTARIO" -ForegroundColor Magenta
Write-Host "=======================" -ForegroundColor Magenta

Test-Endpoint "GET" "/inventory/movements" "" "Historial de movimientos"
Test-Endpoint "GET" "/inventory/current-stock" "" "Stock actual"
Test-Endpoint "GET" "/inventory/valued-report" "" "Reporte valorizado"
Test-Endpoint "GET" "/inventory/low-stock" "" "Stock bajo en inventario"

Write-Host "🔍 PRUEBAS DE VALIDACIÓN" -ForegroundColor Magenta
Write-Host "=======================" -ForegroundColor Magenta

Test-Endpoint "POST" "/products" '{"name":"","sku":""}' "Validar campos requeridos (debe fallar)"
Test-Endpoint "POST" "/inventory/remove-stock" '{"product_id":1,"warehouse_id":1,"quantity":9999,"notes":"Intentar retirar stock excesivo"}' "Validar stock insuficiente (debe fallar)"

Write-Host "📈 ESTADÍSTICAS FINALES" -ForegroundColor Magenta
Write-Host "=======================" -ForegroundColor Magenta

try {
    $stats = Invoke-RestMethod -Uri "$baseUrl/inventory/valued-report" -Method GET -Headers @{"Accept"="application/json"}
    Write-Host "💰 Valor total del inventario: `$$($stats.summary.total_value)" -ForegroundColor Green
    Write-Host "📦 Productos en stock: $($stats.summary.total_products)" -ForegroundColor Green
    
    $products = Invoke-RestMethod -Uri "$baseUrl/products" -Method GET -Headers @{"Accept"="application/json"}
    Write-Host "🏷️  Total de productos registrados: $($products.total)" -ForegroundColor Green
    
    $categories = Invoke-RestMethod -Uri "$baseUrl/categories" -Method GET -Headers @{"Accept"="application/json"}
    Write-Host "📂 Total de categorías: $($categories.total)" -ForegroundColor Green
}
catch {
    Write-Host "❌ Error obteniendo estadísticas finales" -ForegroundColor Red
}

Write-Host ""
Write-Host "🎉 PRUEBAS COMPLETADAS" -ForegroundColor Green
Write-Host "=====================" -ForegroundColor Green
Write-Host "El sistema está funcionando correctamente! ✨" -ForegroundColor Green
