# BOOT

Este archivo define el proceso obligatorio de inicialización del proyecto.

No debes modificar ningún archivo hasta completar todos los pasos indicados.

Siempre cargar las skills `/caveman full y /ponytail full`

---

# Paso 1 - Leer documentación

Leer completamente todos los archivos Markdown contenidos en:

- `.agents/context/`
- `.agents/prompts/`

Si existen, leer también:

- `.agents/WORKLOG.md`
- `.agents/NEXT_TASK.md`
- `.agents/prompts/decisions.md`

Si falta cualquiera de los archivos obligatorios:

- detener el proceso
- indicar exactamente cuál falta
- no inventar reglas alternativas
- esperar autorización del usuario

---

# Paso 2 - Analizar el proyecto

Utilizar `codebase-memory-mcp` Siempre.

Si no está disponible:

- informar la situación
- ponerlo en marcha, nunca continuar sin indexar el proyecto
- no asumir la arquitectura

El análisis debe identificar como mínimo:

- Arquitectura general
- Módulos involucrados
- Dependencias
- Archivos afectados
- Riesgos
- Impacto esperado

Nunca asumir nombres de modelos, Controladores, endpoints o servicios sin verificarlos.

---

# Paso 3 - Presentar el análisis

Antes de escribir código debes presentar:

- Arquitectura encontrada
- Dependencias
- Archivos que serán modificados
- Riesgos
- Impacto esperado
- Plan de implementación

No escribir código antes de completar este paso.

---

# Paso 4 - Implementación

Implementar únicamente el alcance solicitado.

Siempre:

- reutilizar componentes existentes
- mantener compatibilidad
- minimizar la cantidad de archivos modificados
- evitar duplicación de código
- evitar complejidad innecesaria

No implementar funcionalidades adicionales.

No realizar refactorizaciones salvo que:

- sean imprescindibles
- corrijan errores críticos
- el usuario las solicite

---

# Paso 5 - Docker

Todos los comandos deben ejecutarse siguiendo las instrucciones de:

`.agents/prompts/docker.md`

Nunca ejecutar comandos directamente sobre el sistema operativo cuando el proyecto defina Docker como entorno de ejecución.

---

# Paso 6 - Validaciones

Después de cualquier modificación de archivos dentro de las aplicaciones ejecutar todas las validaciones definidas en:

`.agents/prompts/validation.md`

Si cualquier validación falla:

- corregir el problema
- ejecutar nuevamente todas las validaciones

No finalizar la tarea mientras exista alguna validación fallida.

---

# Paso 7 - Entrega

Al finalizar debes entregar:

## Resumen

- Objetivo implementado
- Cambios realizados

## Archivos

- Lista completa de archivos modificados

## Base de datos

- Migraciones creadas
- Cambios de modelos

## Validaciones

- Tests ejecutados
- Resultado de cada validación
- Comandos utilizados

## Riesgos

- Riesgos detectados
- Compatibilidad

## Próximos pasos

- Recomendaciones y archivo de recomendations.md

---

# Paso 8 - Continuidad

Si la tarea no quedó terminada debes actualizar:

- `.agents/WORKLOG.md`
- `.agents/NEXT_TASK.md`

Indicando:

- trabajo realizado
- trabajo pendiente
- riesgos
- próximo paso recomendado

Nunca finalizar una conversación dejando trabajo sin documentar.
