# Docker Environment

## Regla obligatoria

Todo el backend se ejecuta exclusivamente mediante Docker Compose, con `docker-compose.yaml` de la raíz. Servicios: `app` (PHP-FPM 8.4), `nginx`, `mysql` y `composer` (perfil `tools`).

Nunca ejecutar `php`, `composer`, `artisan` ni `phpunit` sobre el sistema anfitrión. Siempre usar Docker.

Esto incluye las instalaciones de `php.new` en `~/.config/herd-lite`: no usarlas para este proyecto.

---

## Comandos

Levantar el entorno

```bash
docker compose up -d
```

Dependencias (el `vendor/` no existe hasta ejecutar esto)

```bash
docker compose run --rm composer install
docker compose run --rm composer require <paquete>
```

Artisan, migraciones y generadores

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan make:model Equipment -mf
docker compose exec app php artisan tinker
```

Tests

```bash
docker compose exec app php artisan test
```

Formato

```bash
docker compose exec app ./vendor/bin/pint
```

---

## Notas

- La API queda en `http://localhost:8000` (`APP_PORT`); MySQL en `127.0.0.1:3307` (`MYSQL_PORT`).
- Si `nginx` queda reiniciándose con `host not found in upstream "app"`, levantar `app` primero: `docker compose up -d app mysql && docker compose up -d nginx`.
- No incluir credenciales reales en archivos versionados; usar `.env` (ignorado por git).
