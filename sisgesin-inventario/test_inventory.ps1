# Script de Pruebas de Operaciones de Inventario
# SisgesIn - Pruebas específicas de movimientos de stock

Write-Host "📦 INICIANDO PRUEBAS DE OPERACIONES DE INVENTARIO" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan

$baseUrl = "http://127.0.0.1:8000/api"

function Test-InventoryOperation {
    param(
        [string]$Method,
        [string]$Endpoint,
        [string]$Data,
        [string]$Description
    )
    
    Write-Host "🔄 $Description" -ForegroundColor Yellow
    
    try {
        $uri = "$baseUrl$Endpoint"
        $headers = @{
            "Accept" = "application/json"
            "Content-Type" = "application/json"
        }
        
        $response = Invoke-RestMethod -Uri $uri -Method $Method -Headers $headers -Body $Data
        
        Write-Host "   ✅ SUCCESS: $($response.message)" -ForegroundColor Green
        if ($response.data -and $response.data.new_stock) {
            Write-Host "   📊 Nuevo stock: $($response.data.new_stock) unidades" -ForegroundColor White
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

Write-Host "1️⃣  AGREGANDO STOCK" -ForegroundColor Magenta
Write-Host "==================" -ForegroundColor Magenta

Test-InventoryOperation "POST" "/inventory/add-stock" '{"product_id":1,"warehouse_id":1,"quantity":50,"notes":"Entrada de stock desde PowerShell"}' "Agregando 50 unidades del producto 1"
Test-InventoryOperation "POST" "/inventory/add-stock" '{"product_id":2,"warehouse_id":1,"quantity":30,"notes":"Entrada de stock Samsung"}' "Agregando 30 unidades del producto 2"

Write-Host "2️⃣  RETIRANDO STOCK" -ForegroundColor Magenta
Write-Host "==================" -ForegroundColor Magenta

Test-InventoryOperation "POST" "/inventory/remove-stock" '{"product_id":1,"warehouse_id":1,"quantity":5,"notes":"Salida de stock - venta"}' "Retirando 5 unidades del producto 1"
Test-InventoryOperation "POST" "/inventory/remove-stock" '{"product_id":2,"warehouse_id":1,"quantity":3,"notes":"Salida de stock - venta Samsung"}' "Retirando 3 unidades del producto 2"

Write-Host "3️⃣  TRANSFERENCIAS" -ForegroundColor Magenta
Write-Host "=================" -ForegroundColor Magenta

Test-InventoryOperation "POST" "/inventory/transfer-stock" '{"product_id":1,"source_warehouse_id":1,"destination_warehouse_id":2,"quantity":10,"notes":"Transferencia entre almacenes"}' "Transfiriendo 10 unidades del almacén 1 al 2"

Write-Host "4️⃣  AJUSTES DE INVENTARIO" -ForegroundColor Magenta
Write-Host "========================" -ForegroundColor Magenta

Test-InventoryOperation "POST" "/inventory/adjust-stock" '{"product_id":1,"warehouse_id":1,"new_quantity":100,"type":"adjustment","notes":"Ajuste por inventario físico"}' "Ajustando stock a 100 unidades"

Write-Host "5️⃣  VERIFICANDO ESTADO FINAL" -ForegroundColor Magenta
Write-Host "============================" -ForegroundColor Magenta

try {
    Write-Host "📊 Estado actual del inventario:" -ForegroundColor Yellow
    $currentStock = Invoke-RestMethod -Uri "$baseUrl/inventory/current-stock" -Method GET -Headers @{"Accept"="application/json"}
    
    foreach ($stock in $currentStock.data) {
        $stockQty = if ($stock.current_stock) { $stock.current_stock } else { "0" }
        Write-Host "   📦 $($stock.product_name): $stockQty unidades en almacén $($stock.warehouse_name)" -ForegroundColor White
    }
    
    Write-Host ""
    Write-Host "💰 Reporte valorizado:" -ForegroundColor Yellow
    $valuedReport = Invoke-RestMethod -Uri "$baseUrl/inventory/valued-report" -Method GET -Headers @{"Accept"="application/json"}
    Write-Host "   💵 Valor total: `$$($valuedReport.summary.total_value)" -ForegroundColor Green
    Write-Host "   📈 Total productos: $($valuedReport.summary.total_products)" -ForegroundColor Green
    
}
catch {
    Write-Host "❌ Error obteniendo estado final" -ForegroundColor Red
}

Write-Host ""
Write-Host "✨ PRUEBAS DE INVENTARIO COMPLETADAS" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Green
