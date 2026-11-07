<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# ConstrucKit · Prueba Técnica

API REST para gestión de equipos, cargas de combustible y mantenciones.

## Stack

- Laravel 13.x
- PHP 8.4
- MySQL 8.4
- Docker Compose

## Requisitos

- Docker
- Docker Compose

## Instalación y Puesta en Marcha

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd construckit
```

### 2. Crear archivo .env

```bash
cp .env.example .env
```

El `.env` ya tiene valores por defecto para Docker. Cambiar solo si necesario.

### 3. Levantar los contenedores

```bash
docker compose up -d
```

Esto levanta tres servicios: `app` (PHP 8.4), `nginx` y `mysql`.

### 4. Instalar dependencias

```bash
docker compose run --rm composer install
```

### 5. Generar clave de aplicación

```bash
docker compose exec app php artisan key:generate
```

### 6. Ejecutar migraciones

```bash
docker compose exec app php artisan migrate --seed
```

### 7. Acceder a la aplicación

- API: `http://localhost:8000`
- MySQL: `127.0.0.1:3307` (usuario: `construckit`, password: `localpass`)

## Endpoints principales

Todas las rutas, salvo `login`, requieren un token Sanctum.

- `GET /api/v1/equipment/{equipment}/maintenances?page=1`: historial de mantenciones del equipo, paginado.
- `GET /api/v1/equipment/{equipment}/fuel-loads?page=1`: historial de cargas de combustible del equipo, paginado.
- `GET /api/v1/equipment/pending-preventive-maintenance?page=1`: equipos con más de 250 horas desde la última mantención preventiva.
- `GET /api/v1/equipment/{equipment}/report?from=YYYY-MM-DD&to=YYYY-MM-DD`: reporte de consumo y costos por rango.

Los listados históricos devuelven 15 registros por página, ordenados del más reciente al más antiguo. La preventiva pendiente usa un umbral estricto: más de 250 horas; mantenciones correctivas no reinician el contador.

## Comandos Útiles

### Ejecutar tests

```bash
docker compose exec app php artisan test
```

### Verificar formato de código

```bash
docker compose exec app ./vendor/bin/pint --test
```

### Aplicar formato de código

```bash
docker compose exec app ./vendor/bin/pint
```

php artisan make:seeder AdminUserSeeder

### Crear datos de prueba con Tinker

```bash
docker compose exec app php artisan tinker
```

Dentro de Tinker:

```php
\App\Models\User::factory(10)->create();
\App\Models\Equipment::factory(10)->create();
```

### Ver logs

```bash
docker compose logs -f app
docker compose logs -f nginx
```

### Detener los contenedores

```bash
docker compose down
```

### Reiniciar desde cero

```bash
docker compose down -v
docker compose up -d
docker compose run --rm composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

## Notas

- Nunca ejecutar `php`, `composer` ni `artisan` directamente en el host. Todo vía Docker.
- El `vendor/` se genera dentro del contenedor al ejecutar `composer install`.
- Las migraciones corren contra MySQL en el contenedor; los tests usan SQLite en memoria.


## No considerado
 - Considerar un intervalo de mantenimiento preventivo por cada maquinaria.


## Licencia

MIT
