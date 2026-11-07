# Proyecto

Nombre: ConstrucKit

Objetivo: API REST para gestionar el uso del equipamiento (camiones, excavadoras, generadores), las cargas de combustible y las mantenciones. Es una prueba técnica de 3–4 horas; el enunciado completo está en `docs/Prueba.md`.

Stack: Laravel 13, PHP 8.4, MySQL 8.4, Sanctum , Docker Compose. Sin frontend.

Roles: Administrador y Operador. El enunciado solo exige autenticación simple; la diferencia de permisos entre roles aún no está definida.

## Flujos principales (no romper)

1. CRUD de equipos con validación.
2. Registro de cargas de combustible y mantenciones, que actualiza el horómetro del equipo (reglas en `business_rules.md`).
3. Reporte por equipo y rango de fechas.
4. Listado de equipos con mantención preventiva pendiente.
5. Autenticación de la API.

## Estado

Proyecto en desarrollo activo, no esqueleto vacío:

- Laravel Sanctum y Scramble están instalados.
- `routes/api.php` expone API v1 protegida por `auth:sanctum`: login, logout, usuario actual, usuarios, CRUD de equipos y rutas de cargas de combustible.
- Autenticación por token implementada en `AuthController`; `User` usa `HasApiTokens`.
- Equipos: modelo, enums, migración, factory, seeder, FormRequest, Resource y controlador CRUD implementados.
- Cargas de combustible: modelo, enum, migración, factory, FormRequest, Resource y controlador creados; el controlador está incompleto y contiene imports/nombres inconsistentes.
- Mantenciones: enum, modelo y migración creados, pero modelo y esquema siguen vacíos; no hay controlador, request, resource ni rutas.
- Reporte por rango de fechas, preventivas pendientes y servicio transaccional del horómetro aún no están implementados.
- Solo existen tests de ejemplo; no hay cobertura del dominio ni de la API.

Estado del grafo al 2026-11-07: 717 nodos, 1092 relaciones y 7 rutas detectadas. Verificar nuevamente con `codebase-memory-mcp` antes de asumir que este estado sigue vigente.

## Documentación local

`docs/` está en `.gitignore`: existe solo en esta máquina y no se versiona. Si se toma una decisión de `docs/`, copiarla a `prompts/decisions.md` o al README.
