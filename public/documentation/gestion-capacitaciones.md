# Funcionalidad: Gestión de Capacitaciones

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Esta sección del sistema permite a los administradores gestionar los programas de capacitación. La funcionalidad principal incluye la creación de una capacitación con un nombre y una imagen principal. Posteriormente, permite editar la capacitación para añadirle múltiples documentos (PDF, Word, etc.), los cuales se pueden agrupar por día (Día 1, Día 2, Día 3).

## 2. Flujo Principal y Casos de Uso

### a. Listado de Capacitaciones (Admin)
- **Ruta principal:** `GET /capacitaciones` (asociada a la ruta `capacitaciones.index`).
- **Descripción:** Muestra un listado de todas las capacitaciones creadas, ordenadas por la más reciente.

### b. Creación de una Nueva Capacitación
1.  El administrador accede a la ruta `GET /capacitaciones/create` (ruta `capacitaciones.create`).
2.  Se muestra un formulario que solicita un nombre y una imagen principal para el programa de capacitación.
3.  La petición se envía a `POST /capacitaciones` (ruta `capacitaciones.store`).
4.  El sistema valida los datos, guarda la imagen y crea el registro de la capacitación.
5.  Finalmente, redirige al listado principal.

### c. Edición y Gestión de Documentos
1.  El administrador accede a la ruta `GET /capacitaciones/{capacitacione}/edit` (ruta `capacitaciones.edit`).
2.  Se muestra un formulario con los datos actuales de la capacitación y una sección para añadir nuevos documentos.
3.  El administrador puede:
    - Cambiar el nombre.
    - Reemplazar la imagen principal del programa.
    - Subir uno o más documentos, asignando a cada uno un nombre y un "día agrupador" (1, 2 o 3).
4.  La petición de actualización se envía a `PUT/PATCH /capacitaciones/{capacitacione}` (ruta `capacitaciones.update`).
5.  El sistema actualiza los datos, guarda los nuevos documentos y redirige de vuelta al formulario de edición.

### d. Eliminación de un Documento Individual
- **Ruta:** `DELETE /documento-capacitacion/{documento}` (ruta `documentos.destroy`, nombre inferido).
- **Descripción:** Permite eliminar un documento específico de una capacitación sin eliminar la capacitación completa. El sistema borra el archivo físico y el registro de la base de datos.

### e. Eliminación de una Capacitación Completa
1.  La petición se envía a `DELETE /capacitaciones/{capacitacione}` (ruta `capacitaciones.destroy`).
2.  El sistema ejecuta una **transacción de base de datos** para garantizar que toda la operación sea exitosa.
3.  Dentro de la transacción, se eliminan todos los archivos de los documentos asociados, luego se elimina la imagen principal y finalmente se elimina el registro de la capacitación.

### f. Listado Público de Capacitaciones
- **Ruta:** (No definida explícitamente, pero asociada al método `listarcapacitaciones`).
- **Descripción:** Existe una vista pública (`capacitaciones.blade.php`) que muestra un listado de todas las capacitaciones junto con sus documentos asociados para los usuarios finales.

## 3. Componentes Técnicos Clave

* **Rutas:** Definidas como un Recurso de Laravel en `routes/web.php` bajo el nombre `capacitaciones`, además de rutas personalizadas para `destroyDocumento` y `listarcapacitaciones`.
* **Controlador:** `App\Http\Controllers\CapacitacionController.php`.
* **Modelos:**
    * `App\Models\Capacitacion.php`: Representa el programa de capacitación principal.
    * `App\Models\DocumentoCapacitacion.php`: Representa un documento individual asociado a una capacitación.
* **Relación de Base de Datos:** `Capacitacion` tiene una relación de uno a muchos con `DocumentoCapacitacion` (`hasMany`).
* **Vistas (Blade):**
    * `resources/views/panel-capacitaciones/index.blade.php`
    * `resources/views/panel-capacitaciones/create.blade.php`
    * `resources/views/panel-capacitaciones/edit.blade.php`
    * `resources/views/capacitaciones.blade.php` (Vista pública).

## 4. Lógica de Negocio y Reglas Importantes

* **Almacenamiento de Archivos:** Se utiliza un **disco de almacenamiento personalizado** llamado `capacitaciones_public`. Esto es una excelente práctica para mantener los archivos de este módulo organizados y separados del resto.
* **Validación de Archivos:**
    * La imagen principal debe ser `jpeg, png, jpg, webp` y pesar un máximo de 2MB.
    * Los documentos asociados pueden ser `pdf, doc, docx, xls, xlsx, ppt, pptx` y pesar un máximo de 10MB.
* **Atomicidad en Eliminación:** El método `destroy` para una capacitación completa está envuelto en una `DB::transaction`. Esto asegura que si algo falla (por ejemplo, un archivo no se puede borrar), no se elimina el registro de la base de datos, evitando datos inconsistentes.
* **Generación de Nombres de Archivo:** Los nombres de los archivos se sanitizan y se les añade un timestamp para garantizar que sean únicos y evitar conflictos.