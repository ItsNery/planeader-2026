# Funcionalidad: Gestión de Planes Estatales de Desarrollo

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo permite a los administradores gestionar los "Planes Estatales de Desarrollo". La funcionalidad abarca la subida de un documento PDF para cada plan, una imagen de portada, y la asociación de datos clave como el período de gobierno y el nombre del gobernador. El sistema también controla la publicación y el orden de estos planes en el sitio web público.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Planes (Admin)
* **Ruta principal:** Asociada al nombre de ruta `panel-planes-estatales.index`.
* **Descripción:** Muestra un listado de todos los planes estatales. Los planes se ordenan en la vista según el año de inicio de su período de gobierno.

### b. Creación de un Nuevo Plan
1.  Un administrador accede al formulario de creación a través del método `create`.
2.  La petición con los datos y archivos (PDF y portada) se envía al método `store`.
3.  El sistema valida que los datos cumplan con las reglas, como el formato del período (`AAAA` o `AAAA-AAAA`).
4.  Si la validación es exitosa, los archivos se guardan en el servidor y se crea el registro del plan en la base de datos.

### c. Edición de un Plan
1.  Se accede al formulario de edición a través del método `edit`, que busca el plan por su ID.
2.  La petición de actualización se envía al método `update`.
3.  El sistema actualiza los datos del plan. Si se suben nuevos archivos, los anteriores son eliminados del servidor y reemplazados.

### d. Eliminación de un Plan
1.  La petición de borrado se envía al método `destroy`.
2.  El sistema busca el plan por su ID y elimina ambos archivos asociados (el documento PDF de la carpeta `planesest/` y la portada de `portadaplanesest/`).
3.  Posteriormente, elimina el registro de la base de datos.

### e. Actualización Rápida de Estado (Publicado/No Publicado)
* **Descripción:** El controlador utiliza el Trait `UpdatesPublicado`, lo que indica que existe una funcionalidad para cambiar rápidamente el estado de publicación de un plan.

### f. Listado Público de Planes
* **Descripción:** El método `mostrarPlanEstatal` obtiene todos los planes marcados como publicados. Tiene una lógica especial para identificar el "Plan Estatal de Desarrollo 2024-2030" como el plan reciente, cambiar al mas reciente cuand sea necesario, y mostrar los demás ordenados según el campo `orden`. Los datos se presentan en la vista `planestatal`.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\PlanEstatalController.php`.
* **Modelo:** `App\Models\PlanEstatal.php`.
    * Los campos `fillable` son `nombre`, `periodo`, `ruta_documento`, `portada`, `gobernador`, `publicado`, y `orden`.
* **Trait:** `App\Traits\UpdatesPublicado`.
* **Relaciones:** El modelo `PlanEstatal` tiene una relación de uno a muchos (`hasMany`) con el modelo `ProgramaEstatal`.
* **Vistas (Blade):**
    * `resources/views/panel-planes-estatales/index.blade.php`.
    * `resources/views/panel-planes-estatales/crear.blade.php`.
    * `resources/views/panel-planes-estatales/editar.blade.php`.
    * `resources/views/planestatal.blade.php` (Vista pública).

## 4. Lógica de Negocio y Reglas Importantes

* **Gestión de Doble Archivo:** Cada registro del `PlanEstatal` gestiona dos archivos: el documento principal (PDF) y una imagen de portada.
* **Almacenamiento de Archivos:**
    * Los documentos PDF se guardan en la carpeta `public/planesest/`.
    * Las imágenes de portada se guardan en la carpeta `public/portadaplanesest/`.
* **Validación:**
    * En la creación, son obligatorios los campos `nombre`, `periodo`, `ruta_documento`, `portada` y `gobernador`.
    * El campo `periodo` debe tener el formato `AAAA` o `AAAA-AAAA`.
    * El PDF no puede superar los 500MB y la imagen de portada los 6MB.
* **Sistema de Ordenamiento:**
    * El panel de administración ordena los planes por el año de inicio del `periodo`.
    * La vista pública tiene una lógica para destacar un plan reciente y ordenar los demás según el campo `orden`.