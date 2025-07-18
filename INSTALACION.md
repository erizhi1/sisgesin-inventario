# 🚀 Guía de Instalación - Sistema de Gestión de Inventarios

## 📋 Requisitos Previos

Para ejecutar este proyecto Laravel, necesitas instalar:

### 1. PHP 8.2 o superior
**Opción A: Laragon (Recomendado para desarrollo Laravel)**
- Descarga Laragon desde: https://laragon.org/download/
- Instala la versión "Full" que incluye PHP, MySQL, nginx
- Configuración automática de virtual hosts y SSL
- Terminal integrado con Composer y Git

**Opción B: XAMPP (Alternativa tradicional)**
- Descarga XAMPP desde: https://www.apachefriends.org/download.html
- Instala y asegúrate de que PHP esté en tu PATH

**Opción C: PHP standalone**
- Descarga PHP desde: https://windows.php.net/download/
- Agrega PHP a tu PATH de Windows

### 2. Composer (Gestor de dependencias PHP)
- Descarga desde: https://getcomposer.org/download/
- Instala y verifica que esté en tu PATH

### 3. Node.js (Para assets frontend)
- Descarga desde: https://nodejs.org/
- Instala la versión LTS

### 4. MySQL/MariaDB
- **Con Laragon**: Ya incluido (MySQL + HeidiSQL)
- **Con XAMPP**: Ya incluido
- **Standalone**: Descarga desde https://dev.mysql.com/downloads/mysql/

## 🔧 Verificación de Instalación

Ejecuta estos comandos en PowerShell para verificar:

```powershell
php --version
composer --version
node --version
npm --version
```

## ⚡ Instalación Rápida del Proyecto

Una vez que tengas PHP y Composer instalados, ejecuta:

```powershell
# 1. Crear proyecto Laravel
composer create-project laravel/laravel .

# 2. Instalar dependencias Node.js
npm install

# 3. Copiar archivo de configuración
cp .env.example .env

# 4. Generar clave de aplicación
php artisan key:generate

# 5. Configurar base de datos en .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=inventario_db
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Ejecutar migraciones
php artisan migrate

# 7. Iniciar servidor de desarrollo
php artisan serve
```

## 🎯 Siguiente Paso

Después de instalar PHP y Composer, regresa a VS Code y te ayudo a continuar con la configuración automática del proyecto.
