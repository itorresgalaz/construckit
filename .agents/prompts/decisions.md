# DECISIONS

Decisiones permanentes del proyecto.

## Arquitectura

- MVC de Laravel con un único servicio de horómetro; sin capas de dominio ni repositorios.
- Ninguna lógica de negocio en controladores: validan con FormRequest, delegan y responden con Resource.
- Se respeta el Laravel instalado (13.x); el enunciado pide 10 o superior.

## Alcance

- Prioridad: lo que pide `docs/Prueba.md`. Docker, seeders, OpenAPI (Scramble) y UI son opcionales.
- Los documentos de `docs/` son propuestas, no requisitos. Ante conflicto gana la opción más pequeña y explicable.
- Toda decisión ambigua se documenta en el README.

## Base de datos

- Nunca modificar migraciones ya commiteadas.
- Toda modificación de modelos genera nueva migración.
- Dinero en `BIGINT` CLP.

## Entrega

- Commits incrementales que muestren avance, no un único commit final.

## Calidad

- Todo cambio ejecuta las validaciones de `validation.md`.
- Nunca finalizar con tests fallando.

Agregar nuevas decisiones únicamente cuando representen una regla permanente del proyecto.
