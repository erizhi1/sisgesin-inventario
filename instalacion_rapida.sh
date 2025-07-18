#!/bin/bash
# Script de Instalación Rápida - SisgesIn
# Autor: erizhi1 <erich.gomez.aguilera@gmail.com>

echo "🚀 INSTALACIÓN RÁPIDA - SISGESIN"
echo "================================="
echo ""

echo "📋 VERIFICANDO DEPENDENCIAS..."

# Verificar si PHP está disponible
if command -v php >/dev/null 2>&1; then
    echo "✅ PHP encontrado"
else
    echo "❌ PHP no encontrado. Instala PHP primero."
    exit 1
fi

# Verificar si Composer está disponible
if command -v composer >/dev/null 2>&1; then
    echo "✅ Composer encontrado"
else
    echo "❌ Composer no encontrado. Instala Composer primero."
    exit 1
fi

# Verificar si Node.js está disponible
if command -v node >/dev/null 2>&1; then
    echo "✅ Node.js encontrado"
else
    echo "❌ Node.js no encontrado. Instala Node.js primero."
    exit 1
fi

echo ""
echo "🔧 CONFIGURANDO PROYECTO..."

# Instalar dependencias de PHP
echo "📦 Instalando dependencias PHP..."
composer install --no-interaction --prefer-dist

# Copiar archivo de configuración
if [ ! -f ".env" ]; then
    echo "📝 Creando archivo .env..."
    cp .env.example .env
fi

# Generar clave de aplicación
echo "🔑 Generando clave de aplicación..."
php artisan key:generate --no-interaction

# Instalar dependencias de Node.js
echo "📦 Instalando dependencias Node.js..."
npm install

# Instalar dependencias del frontend
echo "📦 Instalando dependencias del frontend..."
cd frontend
npm install
cd ..

echo ""
echo "🎉 INSTALACIÓN COMPLETADA"
echo "========================="
echo ""

echo "🚀 PARA INICIAR EL PROYECTO:"
echo "1. Backend Laravel: php artisan serve"
echo "2. Frontend Vue 3: cd frontend && npm run dev"
echo "3. Abrir navegador: http://localhost:8000"
echo ""

echo "📊 BASE DE DATOS:"
echo "- ✅ SQLite ya configurada con datos de prueba"
echo "- ✅ 12 categorías, 8 marcas, 3 proveedores"
echo "- ✅ 2 almacenes preconfigurados"
echo ""

echo "💡 COMANDOS ÚTILES:"
echo "- Probar API: ./test_api.sh"
echo "- Resumen del sistema: ./system_summary.ps1"
echo ""

echo "🎯 ¡PROYECTO LISTO PARA USAR!"
