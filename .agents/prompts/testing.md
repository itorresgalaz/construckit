# Testing

PHPUnit 12 vía `php artisan test`.

Toda modificación debe incluir:

Tests Feature para endpoints nuevos o modificados.

Tests Unit para lógica aislada (servicio de horómetro).

Cubrir como mínimo las reglas de `context/business_rules.md`: horómetro mayor, igual y menor; reporte; umbral de preventivas (`> 250`).

Nota: `phpunit.xml` usa SQLite en memoria. Las pruebas de concurrencia (`lockForUpdate()`) requieren MySQL real; no se pueden validar con SQLite.

Verificar que:

No existan errores de migraciones.

No existan endpoints rotos.

No romper compatibilidad de API.
