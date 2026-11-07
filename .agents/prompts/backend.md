# Backend Rules

Antes de modificar analizar con codebase-memory e identificar:

- Modelos
- Controladores
- Rutas
- Servicios
- FormRequests
- Resources

Al agregar funcionalidades a la API:

✔ Validar la entrada con un FormRequest
✔ Responder con un Resource
✔ Poner la lógica compartida en un Service (hoy solo el horómetro)
✔ Proteger la ruta con `auth:sanctum`
✔ Crear tests
✔ Crear migraciones cuando corresponda

Rutas REST estándar (`apiResource`); actualizar con `PUT/PATCH`.

No romper compatibilidad de API.
