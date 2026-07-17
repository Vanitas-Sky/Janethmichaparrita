# 🎓 EduTech Connect - Sistema de Gestión de Inventarios

**Gestión centralizada de equipos, reactivos y disponibilidad de espacios en laboratorios y talleres de instituciones educativas.**

## 🚀 Inicio Rápido

### Requisitos Previos
- PHP 8.1+
- Node.js 18+
- Composer
- MySQL 8.0+ (o similar)

### Instalación

1. **Clonar el repositorio**
   ```bash
   git clone <repo-url>
   cd Janethmichaparrita
   ```

2. **Instalar dependencias PHP**
   ```bash
   composer install
   ```

3. **Instalar dependencias Node.js**
   ```bash
   npm install
   ```

4. **Configurar variables de entorno**
   ```bash
   cp .env.example .env
   ```
   Edita `.env` y configura:
   ```
   APP_NAME=EduTechConnect
   APP_DEBUG=true
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=edutech_db
   DB_USERNAME=root
   DB_PASSWORD=
   VITE_API_URL=http://localhost:8000
   ```

5. **Generar clave de aplicación**
   ```bash
   php artisan key:generate
   ```

6. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   ```

7. **Ejecutar seeders (datos de ejemplo)**
   ```bash
   php artisan db:seed
   ```

8. **Construir assets frontend**
   ```bash
   npm run build
   ```

### Desarrollo Local

**Terminal 1: Servidor Laravel**
```bash
php artisan serve
```

**Terminal 2: Servidor Vite (Dev)**
```bash
npm run dev
```

Accede a la aplicación en: `http://localhost:8000`

---

## 🔐 Credenciales de Demostración

| Campo | Valor |
|-------|-------|
| **Email** | `demo@instituto.edu.mx` |
| **Contraseña** | `password` |
| **Rol** | Coordinador de Laboratorio |

---

## 📱 Arquitectura de la Aplicación

### Frontend (Vue 3 + Vite)
```
resources/
├── js/
│   ├── components/
│   │   ├── Auth/          # Componentes de autenticación
│   │   ├── Dashboard/     # Componentes del dashboard
│   │   └── Shared/        # Componentes reutilizables
│   ├── stores/            # Pinia stores (state management)
│   ├── services/          # Servicios API
│   ├── router/            # Vue Router
│   └── app.js            # Punto de entrada
└── css/
    └── app.css           # Tailwind CSS
```

### Backend (Laravel 11)
```
app/
├── Http/Controllers/Api/
│   ├── EquipmentController.php   # CRUD de equipos
│   └── AuthController.php         # Autenticación
├── Models/
│   ├── Equipment.php              # Modelo de equipos
│   └── EquipmentAlert.php         # Modelo de alertas
database/
├── migrations/
└── seeders/
```

---

## 🎨 Paleta de Colores

| Uso | Color | Código |
|-----|-------|--------|
| **Primario** | Blanco / Gris Claro | `#FFFFFF` / `#F8FAFC` |
| **Secundario** | Azul Institucional | `#1E3A8A` |
| **Éxito** | Verde | `#10B981` |
| **Editar** | Azul Vibrante | `#3B82F6` |
| **Alerta** | Rojo Coral | `#EF4444` |

---

## 📋 Vistas Principales

### 1. **Login**
- Autenticación segura con email y contraseña
- Validaciones en tiempo real
- Credenciales de demo visibles

### 2. **Dashboard**
- **Navbar**: Información del usuario y opción de cerrar sesión
- **Estadísticas en tarjetas**: Total de equipos, en mantenimiento, alertas de stock
- **Tabla de Inventario**: Listado CRUD con búsqueda y filtros
- **Botón de Acción**: "Registrar Nuevo Equipo"

### 3. **Modal CRUD**
- Crear nuevo equipo
- Editar equipo existente
- Validaciones completas
- Mensajes de error claros

---

## 🔌 API Endpoints

### Autenticación
```
POST   /api/auth/login          # Iniciar sesión
POST   /api/auth/logout         # Cerrar sesión (protegido)
GET    /api/user                # Obtener usuario actual (protegido)
```

### Equipos (Protegidos)
```
GET    /api/equipment           # Listar equipos
POST   /api/equipment           # Crear equipo
GET    /api/equipment/{id}      # Obtener equipo
PUT    /api/equipment/{id}      # Actualizar equipo
DELETE /api/equipment/{id}      # Eliminar equipo
```

### Utilidades (Protegidos)
```
GET    /api/equipment/stats/dashboard        # Estadísticas
GET    /api/equipment/utilities/laboratories # Laboratorios disponibles
```

---

## ✅ Validaciones

### Backend (Laravel)
- ✓ SKU único y requerido
- ✓ Nombre requerido
- ✓ Cantidad disponible ≤ Cantidad total
- ✓ Números positivos
- ✓ Email válido

### Frontend (Vue)
- ✓ Validaciones en tiempo real
- ✓ Mensajes de error específicos
- ✓ Estados de carga
- ✓ Confirmación de eliminación

---

## 🚨 Alertas de Stock

El sistema genera automáticamente alertas cuando:
- Cantidad disponible ≤ 25% de la cantidad total
- Las alertas se marcan como resueltas cuando el stock vuelve a la normalidad

---

## 📦 Build para Producción

```bash
npm run build
```

Los archivos compilados se generarán en `public/build/`

---

## 🛠️ Estructura de Componentes Vue

### Shared Components
- `BaseButton.vue` - Botón reutilizable con variantes
- `BaseInput.vue` - Input con validaciones
- `BaseModal.vue` - Modal reutilizable

### Auth Components
- `LoginView.vue` - Pantalla de login

### Dashboard Components
- `DashboardView.vue` - Vista principal
- `Navbar.vue` - Barra de navegación
- `StatisticsCards.vue` - Tarjetas de estadísticas
- `InventoryTable.vue` - Tabla con CRUD
- `EquipmentModal.vue` - Modal para crear/editar

---

## 🔒 Seguridad

- ✓ Autenticación con Laravel Sanctum
- ✓ Tokens Bearer en requests
- ✓ CSRF protection
- ✓ Validaciones en backend obligatorias
- ✓ Manejo de errores seguro

---

## 📚 Stack Tecnológico

| Tecnología | Versión | Uso |
|------------|---------|-----|
| **Laravel** | 11 | Backend API |
| **Vue** | 3.4 | Frontend |
| **Vue Router** | 4.2 | Enrutamiento |
| **Pinia** | 2.1 | State Management |
| **Tailwind CSS** | 3.3 | Estilos |
| **Axios** | 1.6 | HTTP Client |
| **Vite** | 5.0 | Build tool |
| **MySQL** | 8.0+ | Base de datos |

---

## 📝 Próximas Fases

- [ ] Reportes y exportación de datos
- [ ] Historial de cambios/auditoría
- [ ] Notificaciones en tiempo real
- [ ] Integración con calendario
- [ ] Gestión de usuarios y permisos
- [ ] API de reservas de espacios

---

## 🤝 Contribución

Para contribuir al proyecto, crea una rama feature y envía un pull request.

```bash
git checkout -b feature/nueva-funcionalidad
git commit -m "feat: descripción del cambio"
git push origin feature/nueva-funcionalidad
```

---

## 📄 Licencia

Este proyecto es propietario de la institución educativa.

---

## 📞 Contacto

Para soporte técnico, contacta al equipo de desarrollo.

**Última actualización:** Julio 2026
