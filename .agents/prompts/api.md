# API

- Rutas en `routes/api.php` (se crea con `php artisan install:api`, que también instala Sanctum). Prefijo `/api`.
- Todo endpoint, salvo el login, exige `auth:sanctum`.
- Errores en JSON: 422 validación, 404 recurso inexistente, 409 conflicto (borrar equipo con historial), 401 sin autenticar.
- `bootstrap/app.php` ya fuerza JSON para `api/*`.
- Paginar los listados.
- Resultado de dinero en CLP entero.
- Entregar colección Postman o ejemplos de llamadas; con uno basta.
