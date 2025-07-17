#!/bin/bash

# Script de Pruebas del Sistema de Gestión de Inventarios
# SisgesIn - Sistema de Gestión de Inventarios

echo "🧪 INICIANDO PRUEBAS DEL SISTEMA DE GESTIÓN DE INVENTARIOS"
echo "=========================================================="

BASE_URL="http://127.0.0.1:8000/api"

# Función para hacer peticiones HTTP y mostrar resultados
test_endpoint() {
    local method=$1
    local endpoint=$2
    local data=$3
    local description=$4
    
    echo "📋 Probando: $description"
    echo "   $method $endpoint"
    
    if [ "$method" = "GET" ]; then
        response=$(curl -s -w "\n%{http_code}" -X GET "$BASE_URL$endpoint" -H "Accept: application/json")
    else
        response=$(curl -s -w "\n%{http_code}" -X $method "$BASE_URL$endpoint" -H "Accept: application/json" -H "Content-Type: application/json" -d "$data")
    fi
    
    http_code=$(echo "$response" | tail -n1)
    response_body=$(echo "$response" | head -n -1)
    
    if [[ $http_code -ge 200 && $http_code -lt 300 ]]; then
        echo "   ✅ SUCCESS ($http_code)"
    else
        echo "   ❌ ERROR ($http_code)"
        echo "   $response_body"
    fi
    echo ""
}

echo "🏷️  PRUEBAS DE CATEGORÍAS"
echo "========================"

test_endpoint "GET" "/categories" "" "Listar todas las categorías"
test_endpoint "GET" "/categories/tree" "" "Obtener árbol de categorías"
test_endpoint "POST" "/categories" '{"name":"Categoría de Prueba","description":"Categoría creada en pruebas","is_active":true}' "Crear nueva categoría"

echo "📦 PRUEBAS DE PRODUCTOS"
echo "======================"

test_endpoint "GET" "/products" "" "Listar todos los productos"
test_endpoint "POST" "/products" '{"name":"Producto Test","sku":"TEST001","description":"Producto de prueba","purchase_price":100.00,"sale_price":150.00,"unit":"unidad","category_id":1,"brand_id":1,"min_stock":10,"is_active":true}' "Crear nuevo producto"
test_endpoint "GET" "/products/search?q=iPhone" "" "Buscar productos por nombre"
test_endpoint "GET" "/products/low-stock" "" "Productos con stock bajo"

echo "📊 PRUEBAS DE INVENTARIO"
echo "======================="

test_endpoint "GET" "/inventory/movements" "" "Historial de movimientos"
test_endpoint "GET" "/inventory/current-stock" "" "Stock actual"
test_endpoint "POST" "/inventory/add-stock" '{"product_id":1,"warehouse_id":1,"quantity":50,"unit_cost":100.00,"reference":"TEST-IN-001","notes":"Entrada de prueba"}' "Agregar stock"
test_endpoint "POST" "/inventory/remove-stock" '{"product_id":1,"warehouse_id":1,"quantity":5,"reference":"TEST-OUT-001","notes":"Salida de prueba"}' "Retirar stock"
test_endpoint "POST" "/inventory/transfer-stock" '{"product_id":1,"source_warehouse_id":1,"destination_warehouse_id":2,"quantity":10,"reference":"TEST-TRANS-001","notes":"Transferencia de prueba"}' "Transferir stock"
test_endpoint "GET" "/inventory/valued-report" "" "Reporte valorizado"
test_endpoint "GET" "/inventory/low-stock" "" "Productos con stock bajo"

echo "🔍 PRUEBAS DE VALIDACIÓN"
echo "======================="

test_endpoint "POST" "/products" '{"name":"","sku":""}' "Validar campos requeridos (debe fallar)"
test_endpoint "POST" "/inventory/remove-stock" '{"product_id":1,"warehouse_id":1,"quantity":9999,"notes":"Intentar retirar más stock del disponible"}' "Validar stock insuficiente (debe fallar)"

echo "📈 RESUMEN FINAL"
echo "==============="

test_endpoint "GET" "/inventory/valued-report" "" "Reporte final de inventario"
test_endpoint "GET" "/products" "" "Total de productos en sistema"
test_endpoint "GET" "/categories" "" "Total de categorías en sistema"

echo "🎉 PRUEBAS COMPLETADAS"
echo "====================="
echo "Revise los resultados arriba para verificar el funcionamiento del sistema."
