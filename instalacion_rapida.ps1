# Script de Instalación Rápida - SisgesIn
# Autor: erizhi1 <erich.gomez.aguilera@gmail.com>

Write-Host "🚀 INSTALACIÓN RÁPIDA - SISGESIN" -ForegroundColor Cyan
Write-Host "=================================" -ForegroundColor Cyan

Write-Host ""
Write-Host "📋 INSTALANDO DEPENDENCIAS..." -ForegroundColor Yellow

# Verificar si PHP está disponible
if (Get-Command php -ErrorAction SilentlyContinue) {
    Write-Host "✅ PHP encontrado" -ForegroundColor Green
} else {
    Write-Host "❌ PHP no encontrado. Instala PHP primero." -ForegroundColor Red
    exit 1
}

# Verificar si Composer está disponible
if (Get-Command composer -ErrorAction SilentlyContinue) {
    Write-Host "✅ Composer encontrado" -ForegroundColor Green
} else {
    Write-Host "❌ Composer no encontrado. Instala Composer primero." -ForegroundColor Red
    exit 1
}

# Verificar si Node.js está disponible
if (Get-Command node -ErrorAction SilentlyContinue) {
    Write-Host "✅ Node.js encontrado" -ForegroundColor Green
} else {
    Write-Host "❌ Node.js no encontrado. Instala Node.js primero." -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "🔧 CONFIGURANDO PROYECTO..." -ForegroundColor Yellow

# Instalar dependencias de PHP
Write-Host "📦 Instalando dependencias PHP..." -ForegroundColor White
composer install --no-interaction --prefer-dist

# Copiar archivo de configuración
if (!(Test-Path ".env")) {
    Write-Host "📝 Creando archivo .env..." -ForegroundColor White
    Copy-Item ".env.example" ".env"
}

# Generar clave de aplicación
Write-Host "🔑 Generando clave de aplicación..." -ForegroundColor White
php artisan key:generate --no-interaction

# Instalar dependencias de Node.js
Write-Host "📦 Instalando dependencias Node.js..." -ForegroundColor White
npm install

# Instalar dependencias del frontend
Write-Host "📦 Instalando dependencias del frontend..." -ForegroundColor White
Set-Location "frontend"
npm install
Set-Location ".."

Write-Host ""
Write-Host "🎉 INSTALACIÓN COMPLETADA" -ForegroundColor Green
Write-Host "=========================" -ForegroundColor Green

Write-Host ""
Write-Host "🚀 PARA INICIAR EL PROYECTO:" -ForegroundColor Yellow
Write-Host "1. Backend Laravel: php artisan serve" -ForegroundColor White
Write-Host "2. Frontend Vue 3: cd frontend && npm run dev" -ForegroundColor White
Write-Host "3. Abrir navegador: http://localhost:8000" -ForegroundColor White

Write-Host ""
Write-Host "📊 BASE DE DATOS:" -ForegroundColor Yellow
Write-Host "- ✅ SQLite ya configurada con datos de prueba" -ForegroundColor Green
Write-Host "- ✅ 12 categorías, 8 marcas, 3 proveedores" -ForegroundColor Green
Write-Host "- ✅ 2 almacenes preconfigurados" -ForegroundColor Green

Write-Host ""
Write-Host "💡 COMANDOS ÚTILES:" -ForegroundColor Yellow
Write-Host "- Probar API: .\test_api.ps1" -ForegroundColor White
Write-Host "- Probar inventario: .\test_inventory.ps1" -ForegroundColor White
Write-Host "- Resumen del sistema: .\system_summary.ps1" -ForegroundColor White

Write-Host ""
Write-Host "🎯 ¡PROYECTO LISTO PARA USAR!" -ForegroundColor Green
