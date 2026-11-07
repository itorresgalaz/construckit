# Seguridad

Nunca exponer tokens, API keys ni passwords.

Validar autenticación y autorización antes de cualquier modificación de datos.

No devolver información sensible; usar variables de entorno.

Todo endpoint nuevo exige `auth:sanctum`, salvo login.

Validar entrada en FormRequests.

No registrar credenciales ni tokens en logs.
