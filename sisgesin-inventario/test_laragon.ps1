#!/usr/bin/env pwsh
# Script para verificar la configuración de SisgesIn en Laragon

Write-Host "🚀 Verificando configuración de SisgesIn en Laragon..." -ForegroundColor Cyan
Write-Host ""

# Verificar virtual host
Write-Host "📡 Verificando virtual host..." -ForegroundColor Yellow
try {
    $response = Invoke-WebRequest -Uri "http://sisgesin.test" -UseBasicParsing -TimeoutSec 10
    Write-Host "✅ Virtual host funcionando - Status: $($response.StatusCode)" -ForegroundColor Green
} catch {
    Write-Host "❌ Virtual host no disponible. Reinicia Laragon." -ForegroundColor Red
    Write-Host "   Error: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host ""

# Verificar API
Write-Host "🔌 Verificando API..." -ForegroundColor Yellow
try {
    $apiResponse = Invoke-RestMethod -Uri "http://sisgesin.test/api/v1/categories" -Method GET -TimeoutSec 10
    Write-Host "✅ API funcionando - Categorías encontradas: $($apiResponse.data.Count)" -ForegroundColor Green
} catch {
    Write-Host "❌ API no disponible" -ForegroundColor Red
    Write-Host "   Error: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host ""

# Verificar SSL
Write-Host "🔒 Verificando SSL..." -ForegroundColor Yellow
try {
    $sslResponse = Invoke-WebRequest -Uri "https://sisgesin.test" -UseBasicParsing -TimeoutSec 10
    Write-Host "✅ SSL funcionando - Status: $($sslResponse.StatusCode)" -ForegroundColor Green
} catch {
    Write-Host "⚠️ SSL no disponible (normal en primera configuración)" -ForegroundColor Yellow
}

Write-Host ""

# Verificar base de datos
Write-Host "🗄️ Verificando base de datos..." -ForegroundColor Yellow
$dbTest = php artisan tinker --execute="echo App\Models\Product::count();"
if ($dbTest -match '\d+') {
    Write-Host "✅ Base de datos funcionando - Productos: $($Matches[0])" -ForegroundColor Green
} else {
    Write-Host "❌ Problema con la base de datos" -ForegroundColor Red
}

Write-Host ""
Write-Host "🎉 Verificación completada!" -ForegroundColor Cyan
Write-Host ""
Write-Host "📋 URLs disponibles:" -ForegroundColor White
Write-Host "   🌐 Principal: http://sisgesin.test" -ForegroundColor Gray
Write-Host "   🔒 SSL: https://sisgesin.test" -ForegroundColor Gray
Write-Host "   📊 API: http://sisgesin.test/api/v1/" -ForegroundColor Gray
Write-Host ""
Write-Host "🛠️ Panel Laragon: Click derecho en el ícono de Laragon" -ForegroundColor White
