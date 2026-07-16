# ⚡ Guía Rápida de Ejecución - EduTech Connect

## 🚀 Inicio en 5 Minutos

### 1️⃣ Instalar Dependencias
```bash
# Backend
composer install

# Frontend
npm install
```

### 2️⃣ Configurar Entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Editar las siguientes líneas en .env:
# DB_DATABASE=edutech_db
# DB_USERNAME=root
# DB_PASSWORD=<tu_contraseña>
```

### 3️⃣ Preparar Base de Datos
```bash
# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Cargar datos de ejemplo (opcional)
php artisan db:seed
```

### 4️⃣ Ejecutar en Desarrollo
```bash
# Terminal 1: Servidor Laravel (API)
php artisan serve

# Terminal 2: Dev server Vite (Frontend)
npm run dev
```

### 5️⃣ Acceder a la Aplicación
```
🌐 http://localhost:8000
```

---

## 🔐 Credenciales de Login

```
Email:    demo@instituto.edu.mx
Password: password
```

---

## ❌ Solución de Problemas

### Error: "SQLSTATE[HY000]: General error: 3"
**Causa:** MySQL no tiene soporte para full-text search  
**Solución:**
```sql
ALTER TABLE equipment MODIFY FULLTEXT INDEX ft_name_sku (name, sku);
```

### Error: "No such file or directory: node_modules"
**Solución:**
```bash
rm -rf node_modules package-lock.json
npm install
```

### Error: "Connection refused" (Database)
**Causa:** MySQL no está corriendo  
**Solución:** Inicia el servidor MySQL
```bash
# Windows
mysql -u root -p

# O usa XAMPP/WAMP
```

### Port 8000 ya está en uso
**Solución:**
```bash
php artisan serve --port=8001
```

---

## 📁 Estructura de Archivos Clave

```
Janethmichaparrita/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── EquipmentController.php
│   │   └── AuthController.php
│   └── Models/
│       ├── Equipment.php
│       └── EquipmentAlert.php
├── resources/
│   ├── js/
│   │   ├── components/
│   │   ├── stores/
│   │   ├── router/
│   │   └── services/
│   ├── css/
│   │   └── app.css
│   └── views/
│       └── welcome.blade.php
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── package.json
├── vite.config.js
├── tailwind.config.js
└── .env
```

---

## 🧪 Funcionalidades para Probar

### 1. Login
- [x] Accede con `demo@instituto.edu.mx` / `password`
- [x] Intenta credenciales inválidas

### 2. Dashboard
- [x] Observa las 3 tarjetas de estadísticas
- [x] Verifica la tabla de inventario con 5 equipos

### 3. Buscar
- [x] Usa la barra de búsqueda para filtrar equipos
- [x] Prueba búsqueda por nombre o SKU

### 4. Crear Equipo
- [x] Click en "+ Registrar Nuevo Equipo"
- [x] Completa el formulario
- [x] Verifica la validación de campos
- [x] Guarda y observa en la tabla

### 5. Editar Equipo
- [x] Click en el icono de edición
- [x] Modifica los datos
- [x] Actualiza
- [x] Verifica cambios en la tabla

### 6. Eliminar Equipo
- [x] Click en el icono de papelera
- [x] Confirma la eliminación
- [x] Verifica que desaparece de la tabla

### 7. Stock Bajo
- [x] Busca equipo con stock bajo (Ácido Sulfúrico)
- [x] Observa el icono de alerta
- [x] Verifica que se cuenta en "Alertas de Stock Bajo"

### 8. Logout
- [x] Click en "Cerrar Sesión"
- [x] Verifica redirección a login

---

## 🔧 Comandos Útiles

```bash
# Ejecutar migraciones
php artisan migrate

# Revertir migraciones
php artisan migrate:rollback

# Refresco completo de BD
php artisan migrate:refresh --seed

# Crear usuario adicional
php artisan tinker
# En el prompt:
# User::create(['name'=>'Nuevo','email'=>'new@test.com','password'=>Hash::make('password')])

# Ver rutas API
php artisan route:list --path=api

# Build para producción
npm run build

# Limpiar cache
php artisan cache:clear
php artisan config:clear
```

---

## 📊 Estado de la Aplicación

| Aspecto | Estado |
|---------|--------|
| Backend API | ✅ Funcional |
| Frontend SPA | ✅ Funcional |
| Autenticación | ✅ Funcional |
| CRUD Equipos | ✅ Funcional |
| Validaciones | ✅ Funcional |
| Responsivo | ✅ Funcional |
| Tests | ⏳ Próxima fase |

---

## 🆘 Reportar Problemas

Si encuentras un problema:
1. Verifica el archivo `INSTALACION.md`
2. Revisa los logs: `storage/logs/laravel.log`
3. Comprueba la consola del navegador (F12)
4. Contacta al equipo de desarrollo

---

## 📚 Documentación Completa

Ver `INSTALACION.md` para detalles completos sobre:
- Requisitos del sistema
- Configuración de base de datos
- Stack tecnológico
- Estructura del proyecto
- Endpoints de la API

---

**¡Listo para desarrollar! 🚀**

Próximo paso: Personalización y adición de nuevas funcionalidades
