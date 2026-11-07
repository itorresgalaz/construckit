# Reglas de negocio

Fuente: `docs/Prueba.md`. Lo marcado como "decisión" no está en el enunciado: documentarlo en el README.

## Equipo

- Campos: código interno (único), tipo, patente (opcional), marca, modelo, horómetro actual, estado.
- Estados: operativo, en mantención, fuera de servicio.
- Tipos conocidos: camión, excavadora, generador.
- Decisión: borrar un equipo con historial responde 409 (FKs con `restrict`).

## Horómetro

- Cargas de combustible y mantenciones traen un horómetro.
- Horómetro mayor al actual: se registra y se actualiza el del equipo.
- Horómetro menor al último registrado: error claro (422), no se registra.
- Decisión: horómetro igual se acepta sin incrementar.
- Registro y actualización del horómetro son atómicos: transacción con `lockForUpdate()` sobre la fila del equipo.
- Toda esta lógica vive en un único servicio compartido por combustible y mantención.

## Dinero

- Montos y costos en CLP, enteros (`BIGINT`). Nunca `float`.

## Reporte (por equipo y rango de fechas)

Devuelve exactamente: litros totales, gasto total en combustible, gasto total en mantenciones, rendimiento promedio en litros por hora de uso.

- Combustible y mantenciones se agregan por separado; un JOIN entre ambos duplica filas.
- Definición exacta de "litros por hora" y manejo de rango sin datos: decisión, documentar.

## Mantención preventiva pendiente

- Equipos con más de 250 horas de horómetro desde su última preventiva, o desde cero si nunca tuvieron una.
- Umbral estricto: `> 250`, no `>= 250`.
- Calcular con una subconsulta; sin N+1.
