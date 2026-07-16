# 📚 EduTech Connect - Sistema de Gestión de Inventarios

**Gestión centralizada de equipos, reactivos y disponibilidad de espacios en laboratorios y talleres de instituciones educativas.**

[![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)](https://laravel.com)
[![Vue](https://img.shields.io/badge/Vue-3.4-green?logo=vue.js)](https://vuejs.org)
[![License](https://img.shields.io/badge/License-Proprietary-blue)](#)
[![Status](https://img.shields.io/badge/Status-Beta-yellow)](#)

---

## 🎯 Visión General

**EduTech Connect** es una plataforma web moderna diseñada para simplificar la gestión de inventarios en laboratorios académicos. Permite a coordinadores y docentes:

✅ **Centralizar inventarios** en una plataforma única  
✅ **Monitorear disponibilidad** de equipos en tiempo real  
✅ **Gestionar alertas** de stock bajo automáticamente  
✅ **Acceder vía web** desde cualquier dispositivo  
✅ **Mantener historial** de cambios en equipos  

---

## 🚀 Inicio Rápido

### ⚡ 5 Minutos

```bash
# 1. Clonar y entrar
git clone <repo> && cd Janethmichaparrita

# 2. Instalar
composer install && npm install

# 3. Configurar
cp .env.example .env
# Editar DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 4. Preparar BD
php artisan key:generate
php artisan migrate --seed

# 5. Ejecutar
php artisan serve        # Terminal 1
npm run dev             # Terminal 2
```

🌐 Accede: **http://localhost:8000**

📧 Demo: `demo@instituto.edu.mx` / `password`

---

## 📚 Documentación

| Documento | Descripción |
|-----------|------------|
| **[INICIO_RAPIDO.md](INICIO_RAPIDO.md)** ⭐ | Guía de ejecución en 5 minutos |
| **[INSTALACION.md](INSTALACION.md)** | Instalación completa y configuración |
| **[PLAN_DESARROLLO.md](PLAN_DESARROLLO.md)** | Roadmap del proyecto |
| **[RESUMEN_IMPLEMENTACION.md](RESUMEN_IMPLEMENTACION.md)** | Lo que se ha completado |

---

## 🏗️ Arquitectura

### Backend
```
Laravel 11 API
├── Autenticación con Sanctum
├── Controladores REST
├── Validaciones de entrada
└── Base de datos MySQL
```

### Frontend
```
Vue 3 SPA con Vite
├── Componentes reutilizables
├── State management con Pinia
├── Enrutamiento con Vue Router
└── Estilos con Tailwind CSS
```

---

## 📊 Características Principales

### 🔐 Autenticación
- ✅ Login seguro con email/password
- ✅ Tokens con Sanctum
- ✅ Logout con revocación automática
- ✅ Guard de rutas protegidas

### 📦 Gestión de Inventario
- ✅ CRUD completo de equipos
- ✅ Búsqueda por nombre o SKU
- ✅ Filtros por laboratorio, estado, categoría
- ✅ Paginación optimizada

### 📈 Estadísticas en Tiempo Real
- ✅ Total de equipos registrados
- ✅ Equipos en mantenimiento
- ✅ Alertas de stock bajo

### 🚨 Alertas Automáticas
- ✅ Detección de stock bajo (≤25%)
- ✅ Generación automática
- ✅ Resolución automática

### 🎨 Diseño
- ✅ Interface moderna y limpia
- ✅ Responsivo (mobile/tablet/desktop)
- ✅ Paleta de colores profesional
- ✅ Accesibilidad

---

## 🔧 Stack Tecnológico

### Backend
- **Laravel 11** - Framework web
- **PHP 8.1+** - Lenguaje
- **MySQL 8.0+** - Base de datos
- **Sanctum** - Autenticación API

### Frontend
- **Vue 3** - Framework JS
- **Vite** - Build tool
- **Tailwind CSS** - Utilidad de estilos
- **Axios** - HTTP client
- **Pinia** - State management
- **Vue Router** - Enrutamiento

---

## 📁 Estructura del Proyecto

```
resources/
├── js/
│   ├── components/
│   │   ├── Auth/
│   │   │   └── LoginView.vue
│   │   ├── Dashboard/
│   │   │   ├── DashboardView.vue
│   │   │   ├── Navbar.vue
│   │   │   ├── StatisticsCards.vue
│   │   │   ├── InventoryTable.vue
│   │   │   └── EquipmentModal.vue
│   │   └── Shared/
│   │       ├── BaseButton.vue
│   │       ├── BaseInput.vue
│   │       └── BaseModal.vue
│   ├── stores/
│   │   ├── auth.js
│   │   └── equipment.js
│   ├── services/
│   │   └── api.js
│   └── router/
│       └── index.js
└── css/
    └── app.css
```

---

## 🔌 API REST

### Autenticación
```
POST   /api/auth/login       - Login
POST   /api/auth/logout      - Logout
GET    /api/user             - Usuario actual
```

### Equipos (Protegidos)
```
GET    /api/equipment              - Listar
POST   /api/equipment              - Crear
GET    /api/equipment/{id}         - Obtener
PUT    /api/equipment/{id}         - Actualizar
DELETE /api/equipment/{id}         - Eliminar
GET    /api/equipment/stats/dashboard      - Estadísticas
GET    /api/equipment/utilities/laboratories - Laboratorios
```

---

## 🎨 Paleta de Colores

| Elemento | Color | Código |
|----------|-------|--------|
| Fondo | Blanco | `#FFFFFF` |
| Fondo Secundario | Gris Claro | `#F8FAFC` |
| Primario | Azul Institucional | `#1E3A8A` |
| Éxito | Verde | `#10B981` |
| Editar | Azul Vibrante | `#3B82F6` |
| Alerta | Rojo Coral | `#EF4444` |

---

## 🧪 Testing

### Credenciales de Demo
```
Email:    demo@instituto.edu.mx
Password: password
```

### Funcionalidades para Probar
1. ✅ Login/Logout
2. ✅ Ver estadísticas
3. ✅ Listar equipos
4. ✅ Buscar/Filtrar
5. ✅ Crear equipo
6. ✅ Editar equipo
7. ✅ Eliminar equipo
8. ✅ Ver alertas de stock

---

## 📊 Estado del Proyecto

| Componente | Estado |
|-----------|--------|
| Backend API | ✅ 100% |
| Frontend SPA | ✅ 100% |
| Autenticación | ✅ 100% |
| CRUD Equipos | ✅ 100% |
| Validaciones | ✅ 100% |
| Diseño | ✅ 100% |
| Tests | ⏳ Próxima fase |
| Deployment | ⏳ Próxima fase |

---

## 🛠️ Comandos Útiles

```bash
# Migraciones
php artisan migrate
php artisan migrate:rollback
php artisan migrate:refresh --seed

# Servidor
php artisan serve
php artisan serve --port=8001

# Frontend
npm run dev
npm run build

# CLI de Laravel
php artisan tinker

# Ver rutas
php artisan route:list --path=api
```

---

## 🚀 Build para Producción

```bash
# Compilar assets
npm run build

# El output va a public/build/
```

---

## 🆘 Problemas Comunes

**¿La BD no conecta?**  
→ Verifica `INICIO_RAPIDO.md` → Solución de problemas

**¿Puerto 8000 en uso?**  
→ `php artisan serve --port=8001`

**¿npm install falla?**  
→ `npm cache clean --force && npm install`

---

## 📝 Licencia

Propiedad intelectual de la institución educativa.

---

## 🙏 Créditos

Desarrollado con 💙 para mejorar la gestión de laboratorios educativos.

---

## 📞 Soporte

Para preguntas o problemas: contacta al equipo de desarrollo

---

**Última Actualización:** 16 de Julio, 2026  
**Versión:** 1.0.0-beta  
**[Ver Documentación Completa →](INSTALACION.md)**

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
