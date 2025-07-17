# 📦 SisgesIn - Sistema de Gestión de Inventarios

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/Vue.js-3.5-brightgreen.svg" alt="Vue Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/API-RESTful-green.svg" alt="API RESTful">
  <img src="https://img.shields.io/badge/Status-Desarrollo-yellow.svg" alt="Estado">
  <img src="https://img.shields.io/badge/Frontend-Vue%203-4FC08D.svg" alt="Frontend">
  <img src="https://img.shields.io/badge/Build-Vite-646CFF.svg" alt="Build Tool">
</p>

## 🎯 Descripción

**SisgesIn** es un Sistema de Gestión de Inventarios moderno y completo desarrollado con **Laravel 10** + **Vue 3**, diseñado para empresas que necesitan un control detallado de sus productos, stock y movimientos de inventario. 

### 🌟 **Stack Tecnológico Moderno**
- **Backend:** Laravel 10 con API RESTful completa
- **Frontend:** Vue 3 + Vite + TailwindCSS
- **Base de datos:** SQLite/MySQL con Eloquent ORM
- **Arquitectura:** SPA (Single Page Application) con integración Laravel-Vue

## ✨ Características Implementadas

### 🏗️ **Backend Completo (Laravel 10)**
- ✅ **API RESTful** con 30+ endpoints documentados
- ✅ **Arquitectura de servicios** para lógica de negocio
- ✅ **Base de datos optimizada** con migraciones y relaciones
- ✅ **Sistema de corrección automática** de stock negativos
- ✅ **Validaciones robustas** y manejo de errores
- ✅ **Seeders** con datos de prueba

### 🎨 **Frontend Moderno (Vue 3)**
- ✅ **Vue 3** con Composition API
- ✅ **Vite** para desarrollo ultra-rápido
- ✅ **TailwindCSS 4.x** para styling moderno
- ✅ **Componentes reutilizables** y arquitectura escalable
- ✅ **Estado reactivo** con Pinia
- ✅ **Integración Laravel-Vite** optimizada

### 📊 **Gestión de Inventario**
- ✅ **CRUD completo** de productos, categorías, marcas, proveedores
- ✅ **Control de stock** con entradas, salidas, transferencias
- ✅ **Reportes valorizados** del inventario
- ✅ **Alertas de stock bajo** automáticas
- ✅ **Historial completo** de movimientos
- ✅ **Transferencias entre almacenes**

### 🔧 **Herramientas de Desarrollo**
- ✅ **Scripts PowerShell** para pruebas automatizadas
- ✅ **Interfaz web** para testing de API
- ✅ **Hot Module Replacement** con Vite
- ✅ **Scripts de desarrollo** para Laragon
- ✅ **Validación** de todas las operaciones

## 🛠️ Tecnologías Utilizadas

### **Backend**
- **Laravel 10** - Framework PHP moderno
- **PHP 8.2+** - Lenguaje de programación
- **SQLite/MySQL** - Base de datos (configurable)
- **Eloquent ORM** - Manejo de base de datos
- **Composer** - Gestor de dependencias PHP

### **Frontend**
- **Vue 3** - Framework JavaScript progresivo
- **Vite 6.x** - Build tool ultra-rápido
- **TailwindCSS 4.x** - Framework CSS utility-first
- **Pinia** - State management para Vue
- **Vue Router** - Enrutamiento SPA

### **API y Servicios**
- **API RESTful** - Arquitectura de servicios web
- **JSON** - Formato de intercambio de datos
- **Repository Pattern** - Patrón de diseño
- **Service Layer** - Capa de lógica de negocio
- **Laravel Vite Plugin** - Integración frontend-backend

### **Desarrollo y Testing**
- **PowerShell** - Scripts de automatización
- **cURL** - Testing de API
- **Git** - Control de versiones
- **VS Code** - Entorno de desarrollo
- **Hot Module Replacement** - Desarrollo en tiempo real

## 📁 Estructura del Proyecto

```
app/
├── Http/Controllers/Api/     # Controladores API
│   ├── CategoryController.php
│   ├── ProductController.php
│   └── InventoryController.php
├── Models/                   # Modelos Eloquent
│   ├── Product.php
│   ├── Category.php
│   ├── Stock.php
│   └── InventoryMovement.php
├── Services/                 # Lógica de negocio
│   └── InventoryService.php
└── ...

frontend/                     # Aplicación Vue 3
├── src/
│   ├── components/          # Componentes Vue
│   ├── stores/             # Estado con Pinia
│   ├── assets/             # Assets estáticos
│   └── main.js             # Punto de entrada
├── package.json            # Dependencias frontend
└── vite.config.js          # Configuración Vite

resources/
├── js/
│   ├── components/         # Componentes Laravel-Vue
│   └── app.js             # Bootstrap JS
└── views/                  # Vistas Blade

database/
├── migrations/             # Migraciones de BD
└── seeders/               # Datos de prueba

routes/
├── api.php                # Rutas de API
└── web.php                # Rutas web

tests/
├── test_api.ps1           # Pruebas PowerShell
├── test_inventory.ps1     # Pruebas de inventario
├── test_laragon.ps1       # Pruebas Laragon
└── system_summary.ps1     # Resumen del sistema
```

## 🚀 Instalación y Configuración

### Requisitos
- PHP 8.2 o superior
- Composer
- Node.js 18+ y npm
- Git

### Instalación Completa
```bash
# 1. Clonar el repositorio
git clone https://github.com/erizhi1/sisgesin-inventario.git
cd sisgesin-inventario

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias Node.js
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Ejecutar migraciones y seeders
php artisan migrate --seed

# 6. Iniciar servidores de desarrollo
# Terminal 1: Backend Laravel
php artisan serve

# Terminal 2: Frontend Vite (en paralelo)
npm run dev
```

### Desarrollo con Laragon (Windows)
```bash
# Verificar configuración Laragon
.\test_laragon.ps1

# URLs disponibles:
# http://sisgesin.test (virtual host)
# https://sisgesin.test (SSL)
```

### Scripts de Desarrollo
```bash
# Compilar assets para producción
npm run build

# Limpiar cache Laravel
php artisan cache:clear

# Ver logs en tiempo real
php artisan tinker
```

## 📊 Estado Actual

- **🏗️ Backend:** Completamente funcional con API RESTful
- **🎨 Frontend:** Vue 3 estructura base implementada
- **📦 Productos:** 1 producto de prueba (iPhone 15 Pro)
- **🏷️ Categorías:** 12 categorías organizadas jerárquicamente
- **🏭 Marcas:** 8 marcas disponibles (Apple, Samsung, Sony, etc.)
- **📈 API:** 30+ endpoints completamente operativos
- **✅ Estado:** Backend en producción, Frontend en desarrollo

## 🔗 URLs Disponibles

### Desarrollo Local
- **🌐 Backend Laravel:** http://127.0.0.1:8000
- **⚡ Frontend Vite:** http://127.0.0.1:5173
- **📡 API Base:** http://127.0.0.1:8000/api
- **🧪 Interfaz de Pruebas:** http://127.0.0.1:8000/api-test

### Laragon (Windows)
- **🌐 Principal:** http://sisgesin.test
- **🔒 SSL:** https://sisgesin.test
- **📊 API:** http://sisgesin.test/api

## 🧪 Testing

### Scripts de Prueba Disponibles
```powershell
# Pruebas generales del sistema
.\test_api.ps1

# Pruebas específicas de inventario
.\test_inventory.ps1

# Verificar configuración Laragon
.\test_laragon.ps1

# Resumen completo del sistema
.\system_summary.ps1

# Documentación de la API
.\api_docs.ps1
```

### Testing Frontend
```bash
# Ejecutar tests unitarios (cuando estén implementados)
npm run test

# Linting y formato de código
npm run lint

# Build de producción
npm run build
```

## 🎯 Roadmap de Desarrollo

### 🚧 **En Desarrollo Activo**
- [ ] **Dashboard Vue 3** - Interfaz principal con métricas
- [ ] **Gestión de productos** - CRUD completo en frontend
- [ ] **Control de inventario** - Interfaces para movimientos
- [ ] **Reportes interactivos** - Gráficos con Chart.js/Vue
- [ ] **Autenticación SPA** - Login con Laravel Sanctum

### 📋 **Siguiente Sprint**
- [ ] **Sistema de usuarios** - Roles y permisos
- [ ] **Notificaciones** - Toast y alertas en tiempo real
- [ ] **Responsive design** - Mobile-first con TailwindCSS
- [ ] **PWA** - Progressive Web App
- [ ] **API v2** - Versioning y mejoras

### 🔮 **Futuro (Q2-Q3 2025)**
- [ ] **Tests automatizados** - Jest + Vue Test Utils
- [ ] **Docker** - Containerización completa
- [ ] **CI/CD** - GitHub Actions
- [ ] **Mobile App** - React Native/Flutter
- [ ] **Multi-tenancy** - Soporte empresas múltiples
- [ ] **Integración ERP** - Conectores externos

## 📚 Documentación de API

La API RESTful incluye endpoints organizados por módulos:

### 🏷️ **Productos**
- `GET /api/products` - Listar productos con filtros
- `POST /api/products` - Crear nuevo producto
- `GET /api/products/{id}` - Obtener producto específico
- `PUT /api/products/{id}` - Actualizar producto
- `DELETE /api/products/{id}` - Eliminar producto
- `GET /api/products/search` - Búsqueda avanzada
- `GET /api/products/low-stock` - Productos con stock bajo

### 📦 **Inventario**
- `POST /api/inventory/add-stock` - Agregar stock (entradas)
- `POST /api/inventory/remove-stock` - Retirar stock (salidas)
- `POST /api/inventory/transfer-stock` - Transferir entre almacenes
- `POST /api/inventory/adjust-stock` - Ajustes de inventario
- `GET /api/inventory/movements` - Historial de movimientos
- `GET /api/inventory/current-stock` - Stock actual
- `GET /api/inventory/valued-report` - Reporte valorizado

### 🗂️ **Categorías y Maestros**
- `GET /api/categories` - Listar categorías (árbol jerárquico)
- `POST /api/categories` - Crear categoría
- `GET /api/categories/tree` - Estructura de árbol
- Endpoints similares para marcas, proveedores, almacenes

### 📖 **Documentación Completa**
```bash
# Ver documentación interactiva
.\api_docs.ps1

# O visitar:
http://127.0.0.1:8000/api-test
```

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/amazing-feature`)
3. Commit tus cambios (`git commit -m 'Add amazing feature'`)
4. Push a la rama (`git push origin feature/amazing-feature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.

## 👨‍💻 Autor

**erizhi1** - [GitHub](https://github.com/erizhi1)

---

<p align="center">
  <strong>⭐ Si este proyecto te fue útil, ¡dale una estrella! ⭐</strong>
</p>
