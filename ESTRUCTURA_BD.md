# 📊 Estructura de Base de Datos - EduTech Connect

## 🗂️ Tablas Principales

### 1. Tabla `users` - Gestión de Usuarios

**Descripción:** Almacena la información de todos los usuarios del sistema (coordinadores y docentes).

**Campos:**

| Campo | Tipo | Descripción | Validación |
|-------|------|-------------|-----------|
| `id` | BIGINT | Identificador único (PRIMARY KEY) | Auto-incrementado |
| `name` | VARCHAR(255) | Nombre completo del usuario | Obligatorio, máx 255 caracteres |
| `email` | VARCHAR(255) | Correo electrónico | Obligatorio, único, formato válido |
| `email_verified_at` | TIMESTAMP | Fecha de verificación de email | Nullable |
| `password` | VARCHAR(255) | Contraseña encriptada con bcrypt | Obligatorio, mínimo 6 caracteres |
| `role` | ENUM | Rol del usuario | Valores: `'coordinador'`, `'docente'` (default: `'docente'`) |
| `remember_token` | VARCHAR(100) | Token para "recuérdame" | Nullable |
| `created_at` | TIMESTAMP | Fecha de creación | Auto-generado |
| `updated_at` | TIMESTAMP | Fecha de última actualización | Auto-generado |

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `email`

**Relaciones:**
- Un usuario puede registrar múltiples equipos
- Un usuario puede crear múltiples alertas

**SQL:**
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('coordinador', 'docente') DEFAULT 'docente',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

### 2. Tabla `equipos` - Catálogo de Equipos (TU CATÁLOGO ESCOLAR)

**Descripción:** Almacena el inventario de todos los equipos disponibles en los laboratorios de la institución.

**Campos:**

| Campo | Tipo | Descripción | Validación |
|-------|------|-------------|-----------|
| `id` | BIGINT | Identificador único (PRIMARY KEY) | Auto-incrementado |
| `numero_inventario` | VARCHAR(50) | Número de inventario único (ej. EQ-001) | Obligatorio, único, máx 50 caracteres |
| `nombre` | VARCHAR(100) | Nombre del equipo | Obligatorio (ej. Osciloscopio, Microscopio) |
| `laboratorio` | VARCHAR(50) | Laboratorio donde está ubicado | Obligatorio (ej. Electrónica, Biología) |
| `cantidad` | INTEGER | Cantidad disponible del equipo | Obligatorio, mínimo 0 |
| `estado` | ENUM | Estado actual del equipo | Valores: `'Disponible'`, `'Mantenimiento'`, `'Dañado'`, `'Inactivo'` (default: `'Disponible'`) |
| `created_at` | TIMESTAMP | Fecha de creación | Auto-generado |
| `updated_at` | TIMESTAMP | Fecha de última actualización | Auto-generado |

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `numero_inventario`
- INDEX: `laboratorio` (para búsquedas rápidas)
- INDEX: `estado` (para filtrar por estado)
- FULLTEXT: `(nombre, numero_inventario)` (para búsquedas de texto)

**SQL:**
```sql
CREATE TABLE equipos (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    numero_inventario VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    laboratorio VARCHAR(50) NOT NULL,
    cantidad INTEGER NOT NULL DEFAULT 0,
    estado ENUM('Disponible', 'Mantenimiento', 'Dañado', 'Inactivo') DEFAULT 'Disponible',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX idx_laboratorio (laboratorio),
    INDEX idx_estado (estado),
    FULLTEXT idx_nombre_inventario (nombre, numero_inventario)
);
```

**Ejemplos de Datos:**

```sql
INSERT INTO equipos (numero_inventario, nombre, laboratorio, cantidad, estado) VALUES
('EQ-001', 'Osciloscopio Digital Rigol', 'Electrónica', 3, 'Disponible'),
('EQ-002', 'Microscopio Óptico Compuesto', 'Biología', 8, 'Disponible'),
('EQ-003', 'Computadora de Escritorio HP', 'Informática', 2, 'Mantenimiento'),
('EQ-004', 'Reactivo: Ácido Sulfúrico 98%', 'Química', 2, 'Disponible'),
('EQ-005', 'Juego de Pinzas de Precisión', 'Electrónica', 12, 'Disponible'),
('EQ-006', 'Horno Mufla Digital', 'Química', 1, 'Dañado'),
('EQ-007', 'Proyector Multimedia Epson', 'Aula Magna', 1, 'Disponible'),
('EQ-008', 'Generador de Funciones', 'Electrónica', 2, 'Disponible');
```

---

## 📋 Endpoints API - Gestión de Equipos

### Rutas Base Autenticadas
Todas las siguientes rutas requieren un token de Bearer válido en el header:
```
Authorization: Bearer {token}
```

### 1. Listar Equipos
```
GET /api/equipos
```

**Parámetros de Consulta:**
- `buscar` (string, opcional): Buscar por nombre o número de inventario
- `laboratorio` (string, opcional): Filtrar por laboratorio
- `estado` (string, opcional): Filtrar por estado
- `page` (integer, opcional): Número de página (default: 1)

**Ejemplo:**
```
GET /api/equipos?buscar=Osciloscopio&laboratorio=Electrónica&page=1
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Equipos obtenidos exitosamente",
    "data": [
        {
            "id": 1,
            "numero_inventario": "EQ-001",
            "nombre": "Osciloscopio Digital Rigol",
            "laboratorio": "Electrónica",
            "cantidad": 3,
            "estado": "Disponible",
            "created_at": "2026-07-16T10:00:00Z",
            "updated_at": "2026-07-16T10:00:00Z"
        }
    ],
    "pagination": {
        "total": 8,
        "per_page": 15,
        "current_page": 1,
        "last_page": 1
    }
}
```

---

### 2. Crear Equipo
```
POST /api/equipos
```

**Body (JSON):**
```json
{
    "numero_inventario": "EQ-009",
    "nombre": "Multímetro Digital",
    "laboratorio": "Electrónica",
    "cantidad": 5,
    "estado": "Disponible"
}
```

**Validaciones:**
- `numero_inventario`: Obligatorio, string, único, máxáx 50 caracteres
- `nombre`: Obligatorio, string, máxáx 100 caracteres
- `laboratorio`: Obligatorio, string, máxáx 50 caracteres
- `cantidad`: Obligatorio, integer, mínimo 0
- `estado`: Obligatorio, debe ser uno de: Disponible, Mantenimiento, Dañado, Inactivo

**Respuesta Exitosa (201):**
```json
{
    "success": true,
    "message": "Equipo creado exitosamente",
    "data": {
        "id": 9,
        "numero_inventario": "EQ-009",
        "nombre": "Multímetro Digital",
        "laboratorio": "Electrónica",
        "cantidad": 5,
        "estado": "Disponible",
        "created_at": "2026-07-16T10:30:00Z",
        "updated_at": "2026-07-16T10:30:00Z"
    }
}
```

**Error de Validación (422):**
```json
{
    "success": false,
    "message": "Error de validación",
    "errors": {
        "numero_inventario": ["Este número de inventario ya existe"]
    }
}
```

---

### 3. Obtener Equipo Específico
```
GET /api/equipos/{id}
```

**Parámetro:**
- `id` (integer): ID del equipo

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Equipo obtenido exitosamente",
    "data": {
        "id": 1,
        "numero_inventario": "EQ-001",
        "nombre": "Osciloscopio Digital Rigol",
        "laboratorio": "Electrónica",
        "cantidad": 3,
        "estado": "Disponible",
        "created_at": "2026-07-16T10:00:00Z",
        "updated_at": "2026-07-16T10:00:00Z"
    }
}
```

**Error (404):**
```json
{
    "success": false,
    "message": "Equipo no encontrado"
}
```

---

### 4. Actualizar Equipo
```
PUT /api/equipos/{id}
```

**Body (JSON) - Todos los campos son opcionales:**
```json
{
    "nombre": "Osciloscopio Digital Rigol DS1104Z",
    "cantidad": 4,
    "estado": "Mantenimiento"
}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Equipo actualizado exitosamente",
    "data": {
        "id": 1,
        "numero_inventario": "EQ-001",
        "nombre": "Osciloscopio Digital Rigol DS1104Z",
        "laboratorio": "Electrónica",
        "cantidad": 4,
        "estado": "Mantenimiento",
        "created_at": "2026-07-16T10:00:00Z",
        "updated_at": "2026-07-16T11:00:00Z"
    }
}
```

---

### 5. Eliminar Equipo
```
DELETE /api/equipos/{id}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Equipo eliminado exitosamente"
}
```

---

### 6. Obtener Estadísticas
```
GET /api/equipos/estadisticas/dashboard
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Estadísticas obtenidas exitosamente",
    "data": {
        "total_equipos": 8,
        "equipos_disponibles": 7,
        "equipos_mantenimiento": 1,
        "equipos_danados": 1,
        "total_laboratorios": 4
    }
}
```

---

### 7. Obtener Laboratorios
```
GET /api/equipos/utilidades/laboratorios
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Laboratorios obtenidos exitosamente",
    "data": [
        "Aula Magna",
        "Biología",
        "Electrónica",
        "Informática",
        "Química"
    ]
}
```

---

## 🔐 Endpoints de Autenticación

### Login
```
POST /api/auth/login
```

**Body:**
```json
{
    "email": "coordinador@instituto.edu.mx",
    "password": "password"
}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Inicio de sesión exitoso",
    "token": "1|AbCdEfGhIjKlMnOpQrStUvWxYz1234567890",
    "user": {
        "id": 1,
        "name": "Ing. Carlos Mendoza",
        "email": "coordinador@instituto.edu.mx",
        "role": "coordinador"
    }
}
```

---

### Logout (Requiere Token)
```
POST /api/auth/logout
Authorization: Bearer {token}
```

**Respuesta Exitosa (200):**
```json
{
    "success": true,
    "message": "Sesión cerrada exitosamente"
}
```

---

### Obtener Usuario Actual (Requiere Token)
```
GET /api/user
Authorization: Bearer {token}
```

**Respuesta Exitosa (200):**
```json
{
    "id": 1,
    "name": "Ing. Carlos Mendoza",
    "email": "coordinador@instituto.edu.mx",
    "role": "coordinador",
    "email_verified_at": "2026-07-16T10:00:00Z",
    "created_at": "2026-07-16T09:00:00Z",
    "updated_at": "2026-07-16T09:00:00Z"
}
```

---

## 📊 Diagrama de Relaciones

```
┌─────────────────┐
│     users       │
├─────────────────┤
│ id (PK)         │
│ name            │
│ email (UNIQUE)  │
│ password        │
│ role (ENUM)     │
│ created_at      │
│ updated_at      │
└─────────────────┘
        │
        │ registra/administra
        ↓
┌─────────────────────┐
│     equipos         │
├─────────────────────┤
│ id (PK)             │
│ numero_inventario   │
│   (UNIQUE)          │
│ nombre              │
│ laboratorio (INDEX) │
│ cantidad            │
│ estado (ENUM,INDEX) │
│ created_at          │
│ updated_at          │
└─────────────────────┘
```

---

## 🚀 Uso en Desarrollo

### Ejecutar Migraciones
```bash
php artisan migrate
```

### Ejecutar Seeders
```bash
php artisan migrate:fresh --seed
```

### Crear Base de Datos Fresh
```bash
php artisan migrate:fresh --seed
```

---

## ✅ Características de Seguridad

✅ **Autenticación con Sanctum:** Tokens seguros para API REST  
✅ **Encriptación de Contraseñas:** Usando bcrypt  
✅ **Validación de Entrada:** En todos los endpoints  
✅ **Middleware de Autenticación:** Protección de rutas  
✅ **Números de Inventario Únicos:** Previene duplicados  
✅ **Búsqueda Full-Text:** Índices optimizados para búsqueda  

---

## 📝 Notas Importantes

1. **Número de Inventario:** Debe ser único y es identificador único del equipo
2. **Estados Válidos:** Disponible, Mantenimiento, Dañado, Inactivo
3. **Roles de Usuario:** Coordinador (acceso completo), Docente (acceso limitado)
4. **Cantidad:** Siempre debe ser ≥ 0
5. **Laboratorios:** Se crean dinámicamente según los equipos registrados

---

## 📱 Ejemplos de uso en Frontend

### Listar Equipos
```javascript
const response = await fetch('/api/equipos', {
    headers: {
        'Authorization': `Bearer ${token}`
    }
});
const data = await response.json();
```

### Crear Equipo
```javascript
const response = await fetch('/api/equipos', {
    method: 'POST',
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        numero_inventario: 'EQ-009',
        nombre: 'Nuevo Equipo',
        laboratorio: 'Electrónica',
        cantidad: 5,
        estado: 'Disponible'
    })
});
```

---

*Documento actualizado: 16 de Julio, 2026*
