# 🔧 TAREAS TÉCNICAS DETALLADAS - SisgesIn

## 📋 Lista de Tareas por Implementar

### 🎯 PRIORIDAD ALTA - Frontend Vue.js

#### 📦 **1. Configuración del Entorno Frontend**
```bash
# Comandos a ejecutar:
npm create vue@latest frontend
cd frontend
npm install
npm install vue-router@4 pinia axios
npm install -D tailwindcss postcss autoprefixer
npm install chart.js vue-chartjs
npm install vue-toastification
```

**Archivos a crear:**
- `frontend/src/main.js` - Configuración principal de Vue
- `frontend/src/router/index.js` - Configuración de rutas
- `frontend/src/stores/auth.js` - Store de autenticación
- `frontend/src/stores/inventory.js` - Store de inventario
- `frontend/src/services/api.js` - Cliente API
- `frontend/tailwind.config.js` - Configuración de Tailwind

---

#### 🧩 **2. Componentes Base a Crear**

**Layout Components:**
- `src/components/Layout/AppLayout.vue`
- `src/components/Layout/Sidebar.vue`
- `src/components/Layout/Navbar.vue`
- `src/components/Layout/Footer.vue`

**UI Components:**
- `src/components/UI/BaseButton.vue`
- `src/components/UI/BaseInput.vue`
- `src/components/UI/BaseModal.vue`
- `src/components/UI/BaseTable.vue`
- `src/components/UI/BasePagination.vue`
- `src/components/UI/LoadingSpinner.vue`
- `src/components/UI/NotificationToast.vue`

**Form Components:**
- `src/components/Forms/ProductForm.vue`
- `src/components/Forms/CategoryForm.vue`
- `src/components/Forms/StockMovementForm.vue`

---

#### 📱 **3. Vistas/Páginas a Desarrollar**

**Dashboard:**
- `src/views/Dashboard.vue` - Vista principal con métricas

**Productos:**
- `src/views/Products/ProductList.vue` - Lista de productos
- `src/views/Products/ProductCreate.vue` - Crear producto
- `src/views/Products/ProductEdit.vue` - Editar producto
- `src/views/Products/ProductDetail.vue` - Detalles de producto

**Categorías:**
- `src/views/Categories/CategoryList.vue` - Lista de categorías
- `src/views/Categories/CategoryForm.vue` - Formulario de categoría

**Inventario:**
- `src/views/Inventory/StockMovements.vue` - Movimientos de stock
- `src/views/Inventory/StockEntry.vue` - Entrada de stock
- `src/views/Inventory/StockExit.vue` - Salida de stock
- `src/views/Inventory/StockTransfer.vue` - Transferencia entre almacenes
- `src/views/Inventory/StockAdjustment.vue` - Ajustes de inventario
- `src/views/Inventory/CurrentStock.vue` - Stock actual

**Reportes:**
- `src/views/Reports/ValuedReport.vue` - Reporte valorizado
- `src/views/Reports/MovementHistory.vue` - Historial de movimientos
- `src/views/Reports/LowStockAlert.vue` - Alertas de stock bajo

---

#### 🔌 **4. Servicios API a Implementar**

**Archivo: `src/services/api.js`**
```javascript
// Servicios a implementar:
- ProductService.getAll()
- ProductService.create(data)
- ProductService.update(id, data)
- ProductService.delete(id)
- CategoryService.getAll()
- CategoryService.getTree()
- InventoryService.addStock(data)
- InventoryService.removeStock(data)
- InventoryService.transferStock(data)
- InventoryService.getMovements()
- InventoryService.getCurrentStock()
- InventoryService.getValuedReport()
```

---

#### 📊 **5. Stores Pinia a Desarrollar**

**Store de Productos (`src/stores/products.js`):**
```javascript
// Estados y acciones necesarias:
- state: products, loading, error
- actions: fetchProducts, createProduct, updateProduct, deleteProduct
- getters: productsByCategory, activeProducts
```

**Store de Inventario (`src/stores/inventory.js`):**
```javascript
// Estados y acciones necesarias:
- state: movements, currentStock, loading
- actions: addStock, removeStock, transferStock, fetchMovements
- getters: lowStockProducts, totalInventoryValue
```

---

### 🎨 **6. Diseño UI/UX a Implementar**

#### **Paleta de Colores:**
- Primary: `#3B82F6` (Azul)
- Secondary: `#10B981` (Verde)
- Warning: `#F59E0B` (Amarillo)
- Danger: `#EF4444` (Rojo)
- Dark: `#1F2937` (Gris oscuro)

#### **Layout Responsive:**
- Mobile first design
- Sidebar colapsable en móvil
- Tablas responsive con scroll horizontal
- Cards para métricas principales

#### **Iconografía:**
- Heroicons o Feather Icons
- Iconos específicos para cada módulo
- Estados visuales (success, warning, error)

---

### 🔐 **7. Sistema de Autenticación a Implementar**

#### **Backend - Laravel Sanctum:**
```php
// Rutas a crear en routes/api.php:
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
```

#### **Frontend - Auth Store:**
```javascript
// Store de autenticación:
- state: user, token, isAuthenticated
- actions: login, logout, register, fetchUser
- persistencia en localStorage
```

#### **Middleware de Rutas:**
```javascript
// Router guards a implementar:
- requireAuth: verificar autenticación
- requireRole: verificar roles de usuario
- redirectIfAuth: redirigir si ya está autenticado
```

---

### 📊 **8. Dashboard Interactivo**

#### **Métricas a Mostrar:**
- Valor total del inventario
- Número de productos activos
- Movimientos del día/semana/mes
- Productos con stock bajo
- Últimas transacciones

#### **Gráficos a Implementar:**
- Gráfico de líneas: Evolución del valor del inventario
- Gráfico de barras: Productos más valiosos
- Gráfico de dona: Distribución por categorías
- Gráfico de área: Movimientos por periodo

#### **Componentes de Dashboard:**
```vue
<!-- Componentes a crear: -->
<MetricCard title="Valor Total" :value="totalValue" />
<LineChart :data="inventoryTrend" />
<BarChart :data="topProducts" />
<RecentMovements :movements="recentMovements" />
<LowStockAlerts :products="lowStockProducts" />
```

---

### 🧪 **9. Testing a Implementar**

#### **Testing Frontend (Vitest + Vue Test Utils):**
```javascript
// Tests a crear:
- Component tests para todos los componentes UI
- Integration tests para formularios
- E2E tests para flujos principales
- API service tests
```

#### **Testing Backend (PHPUnit):**
```php
// Tests existentes a ampliar:
- Feature tests para nuevos endpoints de auth
- Unit tests para nuevos services
- API tests para todos los endpoints
```

---

### 🚀 **10. Deployment y DevOps**

#### **Docker Configuration:**
```dockerfile
# Archivos a crear:
- Dockerfile (para Laravel)
- Dockerfile.frontend (para Vue.js)
- docker-compose.yml (orquestación completa)
- nginx.conf (configuración del servidor web)
```

#### **CI/CD Pipeline (.github/workflows/):**
```yaml
# Workflows a crear:
- backend-tests.yml (testing del backend)
- frontend-tests.yml (testing del frontend)
- deploy.yml (deployment automático)
```

---

## 🗓️ **Planning de Desarrollo**

### **Semana 1: Base Frontend**
- [ ] Configurar Vue.js + dependencias
- [ ] Crear layout principal y componentes UI base
- [ ] Configurar router y stores básicos
- [ ] Conectar con API de productos (lectura)

### **Semana 2: Módulo Productos**
- [ ] Lista de productos con filtros y búsqueda
- [ ] Formularios create/edit productos
- [ ] Validaciones del lado cliente
- [ ] Tests unitarios de componentes

### **Semana 3: Módulo Inventario**
- [ ] Vistas de movimientos de stock
- [ ] Formularios para add/remove/transfer stock
- [ ] Vista de stock actual
- [ ] Integración con API de inventario

### **Semana 4: Dashboard y Reportes**
- [ ] Dashboard con métricas y gráficos
- [ ] Reportes básicos con filtros
- [ ] Exportación de datos
- [ ] Optimización y testing

---

## 🎯 **Próximos Pasos Inmediatos**

### **Hoy:**
1. Decidir si continuar con Vue.js o explorar otras opciones
2. Crear estructura de carpetas frontend
3. Instalar dependencias básicas

### **Esta Semana:**
1. Configurar entorno de desarrollo frontend
2. Crear primer componente conectado a la API
3. Establecer flujo de trabajo Git para frontend

### **Próximo Sprint (2 semanas):**
1. Módulo completo de productos funcional
2. Layout responsive implementado
3. Primeras integraciones con API

---

**¿Empezamos con la configuración de Vue.js?** 🚀

Todo está listo para comenzar el desarrollo frontend. Tu backend es sólido y la API está completamente funcional, así que podemos enfocarnos 100% en crear una interfaz moderna y eficiente.
