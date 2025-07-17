@echo off
echo ========================================
echo   Sistema de Gestion de Inventarios
echo   Script de Instalacion para Windows
echo ========================================
echo.

REM Agregar XAMPP al PATH temporalmente
set PATH=%PATH%;C:\xampp\php;C:\xampp\mysql\bin
set PATH=%PATH%;%APPDATA%\Composer\vendor\bin

echo [1/7] Verificando PHP...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PHP no encontrado. Por favor instala PHP primero.
    echo 💡 Descarga XAMPP desde: https://www.apachefriends.org/download.html
    pause
    exit /b 1
)
echo ✅ PHP encontrado

echo.
echo [2/7] Verificando Composer...
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Composer no encontrado. Por favor instala Composer primero.
    echo 💡 Descarga desde: https://getcomposer.org/download/
    pause
    exit /b 1
)
echo ✅ Composer encontrado

echo.
echo [3/7] Creando proyecto Laravel...
composer create-project laravel/laravel temp-laravel
if %errorlevel% neq 0 (
    echo ❌ Error al crear proyecto Laravel
    pause
    exit /b 1
)

echo.
echo [4/7] Moviendo archivos...
xcopy temp-laravel\* . /E /H /Y
rmdir /s /q temp-laravel

echo.
echo [5/7] Configurando entorno...
copy .env.example .env
php artisan key:generate

echo.
echo [6/7] Verificando Node.js...
node --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ⚠️  Node.js no encontrado. Instala Node.js para assets frontend.
    echo 💡 Descarga desde: https://nodejs.org/
) else (
    echo ✅ Node.js encontrado
    echo Instalando dependencias frontend...
    npm install
)

echo.
echo [7/7] ¡Instalacion completada!
echo.
echo ========================================
echo   PROXIMOS PASOS:
echo ========================================
echo 1. Configura tu base de datos en .env
echo 2. Ejecuta: php artisan migrate
echo 3. Ejecuta: php artisan serve
echo 4. Visita: http://127.0.0.1:8000
echo ========================================
echo.
pause
