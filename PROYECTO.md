# Sistema de Gestión de Inventarios

## 🎯 Estado del Proyecto
[![Laravel](https://img.shields.io/badge/Laravel-10+-red.svg)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)](https://mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)](https://getbootstrap.com/)

## 📁 Estructura del Proyecto (Una vez instalado)

```
inventario-system/
├── 📂 app/
│   ├── 📂 Http/Controllers/
│   │   ├── 📂 Api/              # Controladores API RESTful
│   │   │   ├── ProductController.php
│   │   │   ├── InventoryController.php
│   │   │   └── ReportController.php
│   │   └── 📂 Web/              # Controladores Web
│   │       ├── DashboardController.php
│   │       ├── ProductController.php
│   │       └── InventoryController.php
│   ├── 📂 Models/
│   │   ├── Product.php          # Modelo de productos
│   │   ├── Category.php         # Categorías
│   │   ├── Supplier.php         # Proveedores
│   │   ├── InventoryMovement.php # Movimientos
│   │   └── StockAdjustment.php  # Ajustes
│   ├── 📂 Services/
│   │   ├── InventoryService.php # Lógica de inventario
│   │   ├── ReportService.php    # Generación de reportes
│   │   └── StockService.php     # Control de stock
│   └── 📂 Http/Requests/
│       ├── ProductRequest.php
│       └── InventoryRequest.php
├── 📂 database/
│   ├── 📂 migrations/           # Migraciones de BD
│   │   ├── create_products_table.php
│   │   ├── create_categories_table.php
│   │   ├── create_suppliers_table.php
│   │   └── create_inventory_movements_table.php
│   └── 📂 seeders/              # Datos de prueba
│       ├── ProductSeeder.php
│       └── CategorySeeder.php
├── 📂 resources/
│   ├── 📂 views/
│   │   ├── 📂 layouts/          # Layouts principales
│   │   │   ├── app.blade.php
│   │   │   └── auth.blade.php
│   │   ├── 📂 components/       # Componentes reutilizables
│   │   ├── 📂 dashboard/        # Vistas del dashboard
│   │   ├── 📂 products/         # CRUD de productos
│   │   ├── 📂 inventory/        # Gestión de inventario
│   │   └── 📂 reports/          # Reportes y estadísticas
│   ├── 📂 js/
│   │   ├── 📂 components/       # Componentes JS
│   │   └── 📂 pages/            # Scripts específicos
│   └── 📂 sass/
│       ├── app.scss
│       └── dashboard.scss
├── 📂 routes/
│   ├── web.php                  # Rutas web
│   └── api.php                  # Rutas API
├── 📂 public/
│   ├── 📂 css/
│   ├── 📂 js/
│   └── 📂 images/
└── 📂 storage/
    └── 📂 logs/                 # Logs del sistema
```

## 🔧 Instalación

### Opción 1: Script Automático (Recomendado)
Ejecuta el script `instalar.bat` y sigue las instrucciones.

### Opción 2: Manual
1. Instala PHP 8.2+ y Composer
2. Ejecuta: `composer create-project laravel/laravel .`
3. Configura `.env`
4. Ejecuta: `php artisan migrate`

## 🚀 Características que Implementaremos

### ✅ Módulo de Productos
- ✅ CRUD completo de productos
- ✅ Gestión de categorías y subcategorías
- ✅ Códigos de barras y SKU
- ✅ Imágenes de productos
- ✅ Control de stock mínimo

### ✅ Control de Inventario
- ✅ Registro de entradas y salidas
- ✅ Transferencias entre almacenes
- ✅ Ajustes de inventario
- ✅ Corrección automática de saldos negativos
- ✅ Historial completo de movimientos

### ✅ Dashboard y Reportes
- ✅ Dashboard con métricas en tiempo real
- ✅ Gráficos interactivos con Chart.js
- ✅ Reportes de inventario valorizado
- ✅ Análisis de rotación de productos
- ✅ Exportación a Excel/PDF

### ✅ API RESTful
- ✅ Endpoints para todas las funcionalidades
- ✅ Autenticación con Sanctum
- ✅ Documentación con Swagger
- ✅ Rate limiting y validaciones

### ✅ Sistema de Usuarios
- ✅ Roles y permisos granulares
- ✅ Auditoría de acciones
- ✅ Perfil de usuario
- ✅ Recuperación de contraseña

## 🎮 Próximos Pasos

1. **Instala PHP y Composer** siguiendo `INSTALACION.md`
2. **Ejecuta** el script `instalar.bat`
3. **Configura** la base de datos en `.env`
4. **¡Comienza a desarrollar!**

¡Tu portafolio tendrá un proyecto increíble! 🚀
