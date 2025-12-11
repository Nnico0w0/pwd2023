# Sistema de Gestión Universitaria - Reservas de Aulas

## Descripción del Sistema

Este es un sistema web completo para la gestión universitaria enfocado en la reserva y administración de aulas académicas. El sistema permite gestionar carreras, materias, profesores, aulas y sus respectivas reservas de una manera integral.

### Funcionalidades Principales

- **Gestión de Carreras**: Administración de programas académicos y carreras universitarias
- **Gestión de Materias**: Control de asignaturas, incluyendo su vinculación con carreras y profesores
- **Gestión de Profesores**: Registro y control del personal docente
- **Gestión de Aulas**: Administración de espacios físicos (capacidad, ubicación, recursos como proyectores, climatización)
- **Sistema de Reservas**: Reserva de aulas para materias específicas con control de horarios
- **Dashboard Interactivo**: Panel de control con visualización de todas las entidades
- **Calendario de Reservas**: Vista temporal de las reservas programadas
- **Autenticación**: Sistema de login con roles de usuario

### Entidades del Sistema

1. **Carrera**: Programas académicos (Ingeniería, Medicina, etc.)
2. **Materia**: Asignaturas asociadas a carreras y profesores
3. **Profesor**: Personal docente con sus datos personales
4. **Aula**: Espacios físicos con características específicas (aforo, proyectores, climatización)
5. **ReservaAula**: Reservas de espacios con fechas, horarios y materias asignadas
6. **Usuario**: Sistema de autenticación con roles administrativos

## Arquitectura y Patrones de Diseño

### Arquitectura General
- **Frontend**: Single Page Application (SPA) con Vue.js 3
- **Backend**: API REST con Yii2 Framework (PHP)
- **Base de Datos**: PostgreSQL
- **Contenedores**: Docker Compose para orquestación

### Patrones de Diseño Implementados

#### 1. **Model-View-Controller (MVC)**
- **Backend**: Yii2 implementa MVC nativo
  - `Models`: Entidades de base de datos (`Carrera`, `Materia`, `Profesor`, `Aula`, `ReservaAula`)
  - `Views`: Vistas PHP para interfaz administrativa
  - `Controllers`: Lógica de negocio y manejo de requests

#### 2. **Active Record Pattern**
- Cada modelo extiende `yii\db\ActiveRecord`
- Mapeo objeto-relacional automático
- Relaciones definidas entre entidades (ej: `Materia` pertenece a `Carrera`)

#### 3. **Repository Pattern (Implícito)**
- Queries específicas en clases `*Query` (ej: `CarreraQuery`, `MateriaQuery`)
- Separación de lógica de acceso a datos

#### 4. **RESTful API Design**
- Endpoints seguros y consistentes
- Métodos HTTP semánticos (GET, POST, PUT, DELETE)
- Responses en formato JSON

#### 5. **Module Pattern (Backend)**
- API modularizada en `/modules/apiv1/`
- Separación clara entre web y API
- Versionado de API

#### 6. **Component-Based Architecture (Frontend)**
- Vue.js 3 con Composition API
- Componentes reutilizables y modulares
- Single File Components (.vue)

#### 7. **Service Layer Pattern**
- `services/api.js` centraliza llamadas a backend
- Separación de lógica de negocio del UI

#### 8. **Router Pattern**
- Vue Router para navegación SPA
- Guards de autenticación
- Rutas protegidas

#### 9. **Factory Pattern**
- Axios instance configurado como factory
- Interceptors para headers y autenticación

#### 10. **Observer Pattern**
- Reactive data con Vue.js
- Watchers y computed properties

### Patrones Arquitectónicos

#### 1. **Layered Architecture**
```
┌─────────────────┐
│   Presentation  │ ← Vue.js Frontend
├─────────────────┤
│    API Layer    │ ← Yii2 REST Controllers
├─────────────────┤
│  Business Logic │ ← Models & Services
├─────────────────┤
│   Data Access   │ ← Active Record
├─────────────────┤
│    Database     │ ← PostgreSQL
└─────────────────┘
```

#### 2. **Microservices-Ready**
- Frontend y Backend completamente desacoplados
- Comunicación vía API REST
- Contenedores independientes

#### 3. **Client-Server Architecture**
- Cliente SPA (Vue.js)
- Servidor API (Yii2)
- Base de datos independiente

## Tecnologías Utilizadas

### Frontend
- **Vue.js 3**: Framework progresivo con Composition API
- **Vite**: Build tool y dev server de nueva generación
- **Vue Router**: Enrutamiento SPA
- **Axios**: Cliente HTTP para API calls
- **CSS3**: Estilos responsive y modernos

### Backend  
- **Yii2 Framework**: Framework PHP con patrón MVC
- **PHP 8.1**: Lenguaje de programación del servidor
- **Apache**: Servidor web
- **JWT**: Autenticación con tokens (firebase/php-jwt)

### Base de Datos
- **PostgreSQL 14**: Sistema de gestión de base de datos relacional
- **Migrations**: Control de versiones de esquema de BD

### DevOps
- **Docker**: Contenedorización de servicios
- **Docker Compose**: Orquestación multi-contenedor

## Cómo Levantar el Sistema

### Prerrequisitos
- Docker y Docker Compose instalados
- Git para clonar el repositorio

### Pasos de Instalación

#### 1. Clonar el repositorio
```bash
git clone <url-del-repositorio>
cd pwa2023-main
```

#### 2. Configurar variables de entorno
```bash
# Exportar el ID del usuario actual para permisos de Docker
export USERID=$(id -u)

# (Opcional) Para producción
export PRODUCCION=false
```

#### 3. Levantar los servicios con Docker Compose
```bash
# Levantar todos los servicios
docker-compose up -d

# Ver logs en tiempo real (opcional)
docker-compose logs -f
```

#### 4. Configurar la base de datos
```bash
# Acceder al contenedor del backend
docker-compose exec backend bash

# Ejecutar migraciones
php yii migrate --interactive=0

# (Opcional) Crear usuario administrador
php yii create-admin/index
```

#### 5. Acceder a la aplicación

- **Frontend (Vue.js)**: http://localhost:5173
- **Backend API**: http://localhost:8000
- **Backend Admin**: http://localhost:8000 (interfaz web de administración)

### Servicios en Ejecución

| Servicio | Puerto | Descripción |
|----------|--------|-------------|
| Frontend | 5173   | Aplicación Vue.js |
| Backend  | 8000   | API Yii2 + Interfaz Admin |
| PostgreSQL | 5432 | Base de datos |

### Comandos Útiles

```bash
# Ver estado de contenedores
docker-compose ps

# Detener servicios
docker-compose down

# Reconstruir imágenes
docker-compose up --build

# Acceder a base de datos
docker-compose exec postgres psql -U pwauser -d pwa

# Logs de un servicio específico
docker-compose logs frontend
docker-compose logs backend
```

## Estructura del Proyecto

```
pwa2023-main/
├── docker-compose.yml          # Orquestación de servicios
├── frontend/                   # Aplicación Vue.js
│   ├── src/
│   │   ├── components/        # Componentes reutilizables
│   │   ├── views/            # Páginas principales
│   │   ├── router/           # Configuración de rutas
│   │   ├── services/         # Servicios API
│   │   └── assets/           # Recursos estáticos
│   ├── package.json
│   └── vite.config.js
├── backend/
│   └── basic/                 # Aplicación Yii2
│       ├── controllers/       # Controladores web
│       ├── models/           # Modelos Active Record
│       ├── views/            # Vistas PHP
│       ├── migrations/       # Migraciones de BD
│       ├── modules/
│       │   └── apiv1/        # API REST v1
│       ├── config/           # Configuraciones
│       └── composer.json
└── data/
    └── pgdata/               # Datos persistentes de PostgreSQL
```

## Desarrollo y Contribución

### Agregar nuevas funcionalidades

1. **Backend**: Crear modelo, controlador y vistas en Yii2
2. **API**: Agregar controller en `modules/apiv1/controllers/`
3. **Frontend**: Crear componente/vista en Vue.js
4. **Servicios**: Agregar métodos en `services/api.js`

### Configuraciones importantes

- **CORS**: Configurado en `BaseController.php` para permitir frontend
- **Autenticación**: Deshabilitada en API para desarrollo
- **Base de datos**: Configuración en `config/db.php`
- **Rutas API**: Definidas automáticamente por Yii2 REST

Este sistema proporciona una base sólida para la gestión universitaria con posibilidad de expansión y escalabilidad mediante patrones de diseño probados y arquitectura moderna.
