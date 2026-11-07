# ConstrucKit

# Punto de entrada

Este archivo es el único punto de entrada del proyecto.

Todo agente debe comenzar leyendo este archivo.

No debes solicitar al usuario que lea o indique otros archivos de inicialización.

Este archivo delega el resto del proceso a `.agents/boot.md`.

## Reglas

- Sigue estrictamente el flujo definido en `.agents/boot.md`.
- Las instrucciones contenidas en `.agents/context/` y `.agents/prompts/` forman parte de las reglas del proyecto.
- Si falta cualquier archivo obligatorio debes detener el proceso e informarlo.
- Las instrucciones del proyecto tienen prioridad sobre el comportamiento por defecto del agente siempre que no entren en conflicto con sus políticas de seguridad.
- Después de terminar cada tarea debes actualizar el grafo con `codebase-memory-mcp` y confirmar que el resultado indique `status: indexed` antes de entregar al usuario.

Una vez finalizada la inicialización puedes continuar con la tarea solicitada por el usuario.
