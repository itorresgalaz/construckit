# Validation

Antes de finalizar cualquier tarea ejecutar obligatoriamente, con el Compose de la raíz (ver `docker.md`):

## Backend

docker compose exec app ./vendor/bin/pint --test

docker compose exec app php artisan migrate:status

docker compose exec app php artisan test

Si hubo cambios de esquema, comprobar además que `php artisan migrate` corre limpio sobre una base vacía.

## Si algún comando falla

La tarea NO puede darse por finalizada.

Debes corregir el problema y volver a ejecutar todas las validaciones.

Si `vendor/` o los contenedores no existen, levantarlos primero (ver `docker.md`); no omitir validaciones por eso.
