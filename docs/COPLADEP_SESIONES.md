# Sesiones COPLADEP

## Modelo de datos

- `sesiones_copladep` es la fuente de verdad de cada sesión. Su `clave` identifica de forma única el año, tipo y sesión, por ejemplo `2026-primera-ordinaria`.
- `invitado_copladeps` representa una invitación dentro de una sesión y conserva el cargo, modalidad y pase de lista de ese momento. No es un padrón global de personas.
- `registro_copladeps` conserva el registro de asistencia y referencia tanto a la invitación como a la sesión.
- `cat_dependencias_copladep` concentra las dependencias reutilizables y se relaciona mediante `dependencia_id`.

## Migración histórica

La migración `2026_10_28_160000_create_copladep_session_catalogs` crea las sesiones de 2026 y enlaza los invitados y registros existentes desde los valores históricos `primera` y `segunda`.

Las columnas históricas `sesion` y `dependencia` se mantienen para no perder trazabilidad de los datos existentes. La aplicación usa `sesion_copladep_id` y `dependencia_id` para todos los flujos nuevos.

## Administración

Desde **Sesiones COPLADEP** se puede crear, editar y consultar una sesión. La ficha de detalle concentra métricas, invitados, registros, monitor y check-in QR.

El catálogo de dependencias se administra desde el enlace **Catálogo de dependencias** en el listado de sesiones. No se permite eliminar una dependencia asociada con invitados históricos.
