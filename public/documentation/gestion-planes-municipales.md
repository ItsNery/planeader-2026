# Funcionalidad: Gestión de Planes Municipales

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo permite a los administradores gestionar los "Planes Municipales de Desarrollo". La funcionalidad principal es subir, clasificar y administrar documentos PDF, asociando cada plan a un municipio y a un período de gobierno específico. El sistema también controla la visibilidad pública y ofrece diferentes formas de consultar la información.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Planes (Admin)
* **Ruta principal:** Asociada al nombre de ruta `panel-planesmunicipales.index`.
* **Descripción:** Muestra un listado de todos los planes municipales para su gestión.

### b. Creación de un Nuevo Plan
1.  Un administrador accede al formulario de creación a través del método `create`, que carga previamente todos los municipios disponibles.
2.  La petición con los datos y el archivo PDF se envía al método `store`.
3.  El sistema valida que los datos cumplan las reglas, como el formato del período (`AAAA-AAAA`) y que el archivo sea un PDF.
4.  Si la validación es exitosa, el archivo se guarda en el servidor y se crea el registro del plan en la base de datos.

### c. Edición de un Plan
1.  Se accede al formulario de edición a través del método `edit`, que busca el plan por su ID.
2.  La petición de actualización se envía al método `update`.
3.  El sistema actualiza los datos del plan. Si se sube un nuevo PDF, el archivo anterior es eliminado del servidor y reemplazado por el nuevo.

### d. Eliminación de un Plan
1.  La petición de borrado se envía al método `destroy`, que busca el plan por su ID.
2.  El sistema elimina el archivo PDF asociado de la carpeta `planesmun/`. También intenta eliminar un archivo de portada de `portadaplanesmun/`, aunque el modelo no gestione portadas.
3.  Posteriormente, elimina el registro de la base de datos.

### e. Actualización Rápida de Estado (Publicado/No Publicado)
* **Descripción:** El controlador utiliza el Trait `UpdatesPublicado`, lo que indica que existe una funcionalidad para cambiar rápidamente el estado de publicación de un plan.

### f. Endpoints y Vistas Personalizadas
* **`mostrarPlanesMunicipales`:** Este método genera una vista (`planesmunicipales`) que muestra los planes agrupados por cada municipio y ordenados por período.
* **`obtenerPlanMunicipal($municipioId)`:** Actúa como un endpoint de API que devuelve la ruta del plan más reciente de un municipio específico en formato JSON. Busca primero el período "2021-2024" y luego "2019-2021".
* **`obtenerPlanes($opcion)`:** Genera una vista de reporte (`reporte_planes`) para un municipio específico, enriqueciendo los datos del municipio con información de macro y microrregión desde el modelo `CatMunicipio`.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\PlanMunicipalController.php`.
* **Modelos:**
    * `App\Models\PlanMunicipal.php`: Representa un plan municipal. Define la tabla `planes_municipales` y tiene una relación `belongsTo` con el modelo `Municipio`.
    * `App\Models\Municipio.php`: Usado para obtener la lista de municipios.
    * `App\Models\CatMunicipio.php`: Se utiliza para obtener datos de macro y microrregiones.
* **Trait:** `App\Traits\UpdatesPublicado`.
* **Vistas (Blade):**
    * `resources/views/panel-planesmunicipales/index.blade.php`.
    * `resources/views/panel-planesmunicipales/crear.blade.php`.
    * `resources/views/panel-planesmunicipales/editar.blade.php`.
    * `resources/views/planesmunicipales.blade.php` (Vista pública).
    * `resources/views/reporte_planes.blade.php` (Vista de reporte).

## 4. Lógica de Negocio y Reglas Importantes

* **Almacenamiento de Archivos:** Los documentos PDF se guardan en la carpeta `public/planesmun/`.
* **Validación:**
    * Los campos `nombre`, `periodo`, `ruta_documento` (solo en creación) y `municipio_id` son obligatorios.
    * El `periodo` debe tener el formato `AAAA-AAAA`.
    * El archivo subido debe ser de tipo `pdf` y no exceder los 500MB.
* **Relaciones:** Es mandatorio que cada `PlanMunicipal` pertenezca a un `Municipio`.
* **Endpoint de API:** El método `obtenerPlanMunicipal` funciona como una API para obtener dinámicamente la ruta del plan más reciente de un municipio, devolviendo datos en JSON.