<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# Sistema de Gestión de Inventarios - Instrucciones para Copilot

## Contexto del Proyecto
Este es un Sistema de Gestión de Inventarios desarrollado con Laravel que incluye:

- **Backend**: Laravel 10+ con API RESTful
- **Frontend**: Bootstrap 5 + jQuery + Blade templates
- **Base de datos**: MySQL con migraciones optimizadas
- **Características**: Gestión de entradas/salidas, corrección automática de stock, reportes, dashboard interactivo

## Estándares de Código

### PHP/Laravel
- Usar PSR-12 para formato de código
- Implementar Repository Pattern para modelos
- Usar Form Requests para validación
- Implementar middleware para autenticación/autorización
- Seguir convenciones de naming de Laravel

### Frontend
- Usar Bootstrap 5 para diseño responsivo
- Implementar componentes reutilizables con Blade
- Usar jQuery para interacciones dinámicas
- Aplicar SweetAlert2 para notificaciones elegantes

### Base de Datos
- Usar migraciones para todos los cambios de esquema
- Implementar Foreign Key constraints
- Usar seeders para datos de prueba
- Optimizar consultas con Eloquent relationships

### API
- Seguir estándares RESTful
- Implementar respuestas consistentes con JSON
- Usar HTTP status codes apropiados
- Implementar versionado de API (/api/v1/)

## Arquitectura del Proyecto

```
app/
├── Http/Controllers/Api/     # Controladores API
├── Http/Controllers/Web/     # Controladores Web
├── Http/Requests/           # Form Requests
├── Models/                  # Modelos Eloquent
├── Repositories/            # Repository Pattern
├── Services/                # Lógica de negocio
└── Traits/                  # Traits reutilizables

resources/
├── views/
│   ├── layouts/            # Layouts principales
│   ├── components/         # Componentes Blade
│   ├── inventory/          # Vistas de inventario
│   └── dashboard/          # Vistas del dashboard
└── js/
    ├── components/         # Componentes JS
    └── pages/             # Scripts por página
```

## Funcionalidades Principales

1. **Gestión de Productos**: CRUD completo con categorías y proveedores
2. **Control de Stock**: Entradas, salidas, transferencias
3. **Corrección Automática**: Sistema automático para saldos negativos
4. **Reportes**: Estadísticas, inventario actual, movimientos
5. **Dashboard**: Métricas en tiempo real con gráficos
6. **API RESTful**: Endpoints completos para integración
7. **Usuarios**: Sistema de roles y permisos

## Reglas Específicas

- Siempre validar datos antes de procesar transacciones de inventario
- Implementar logs para auditoría de movimientos de stock
- Usar transacciones de BD para operaciones críticas
- Mantener historial completo de movimientos
- Implementar soft deletes para datos importantes
