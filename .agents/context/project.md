# Proyecto

Nombre: ConstrucKit

Objetivo: API REST para gestionar el uso del equipamiento (camiones, excavadoras, generadores), las cargas de combustible y las mantenciones. Es una prueba técnica de 3–4 horas; el enunciado completo está en `docs/Prueba.md`.

Stack: Laravel 13, PHP 8.4, MySQL 8.4, Sanctum , Docker Compose. Sin frontend.

Roles: Administrador y Operador. El enunciado solo exige autenticación simple; la diferencia de permisos entre roles aún no está definida. No inventarla: preguntar antes de implementarla.

## Flujos principales (no romper)

1. CRUD de equipos con validación.
2. Registro de cargas de combustible y mantenciones, que actualiza el horómetro del equipo (reglas en `business_rules.md`).
3. Reporte por equipo y rango de fechas.
4. Listado de equipos con mantención preventiva pendiente.
5. Autenticación de la API.

## Estado

Esqueleto Laravel: solo `User`, `routes/web.php` y `routes/console.php`. No existen `routes/api.php`, Sanctum ni modelos de dominio. Verificar con `codebase-memory-mcp` antes de asumir algo distinto.

## Documentación local

`docs/` está en `.gitignore`: existe solo en esta máquina y no se versiona. Si se toma una decisión de `docs/`, copiarla a `prompts/decisions.md` o al README.
