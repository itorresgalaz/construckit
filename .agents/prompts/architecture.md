# Arquitectura

Siempre respetar la arquitectura existente.

Backend

- Laravel 13 (PHP 8.4)
- Laravel Sanctum
- MySQL 8.4

## Estructura

MVC de Laravel: Models, Enums, FormRequests, Resources, Controllers en `app/Http/Controllers/Api`, y un servicio (`app/Services`) solo para la lógica del horómetro.

No crear capas `Domain/Application/Infrastructure`, repositorios, DTOs ni casos de uso: el alcance es 3 tablas y unos 12 endpoints, y un contrato con una sola implementación es abstracción sin uso. Añadir una capa solo con una necesidad real y una decisión explícita.

Los modelos Eloquent son la entidad; no duplicarlos.

## Reglas

- Antes de crear un archivo nuevo verificar que no exista uno equivalente.
- Nunca duplicar código.
- La aplicación está en la raíz del repositorio, no anidada.
