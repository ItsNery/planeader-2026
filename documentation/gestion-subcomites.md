# Funcionalidad: Gestión de Subcomités

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo administra las entidades de "Subcomité". Cada subcomité se define por su nombre, tipo, objetivo, y está asociado a un Plan Estatal. La funcionalidad clave incluye la gestión de dos imágenes por subcomité (un ícono y una imagen de "conformación"), la generación de un `slug` único para su URL, y la visualización de sus documentos asociados en una página de detalle pública.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Subcomités (Admin)
* **Ruta principal:** Asociada al nombre de ruta `panel-subcomites.index`.
* **Descripción:** Muestra una tabla con todos los subcomités para su gestión, con una paginación de 1000 registros por página.

### b. Creación de un Nuevo Subcomité
1.  Un administrador accede al formulario de creación a través del método `create`, que carga previamente los tipos de subcomités y los Planes Estatales disponibles.
2.  La petición con los datos y las dos imágenes requeridas (`conformacion` e `icono`) se envía al método `store`.
3.  El sistema valida los datos, genera un `slug` único para el nuevo subcomité y guarda los archivos y el registro.

### c. Edición de un Subcomité
1.  Se accede al formulario de edición a través del método `edit`, que busca el subcomité por su ID.
2.  La petición de actualización se envía al método `update`.
3.  El sistema actualiza los datos del subcomité. Si se suben nuevas imágenes, las anteriores son eliminadas y reemplazadas.

### d. Eliminación de un Subcomité
1.  La petición de borrado se envía al método `destroy`.
2.  El sistema elimina ambos archivos de imagen asociados (`conformacion` e `icono`) de sus respectivas carpetas.
3.  Posteriormente, elimina el registro de la base de datos.

### e. Listado Público de Subcomités
* **Descripción:** El método `mostrarSubcomites` se encarga de la vista pública (`subcomites`). Tiene una lógica para separar los subcomités en "actuales" (los que pertenecen al 'Plan Estatal de Desarrollo 2024-2030') e "históricos" (todos los demás, agrupados por su plan estatal).

### f. Detalle Público de un Subcomité
* **Ruta:** Se accede a través de una URL con el `slug` del subcomité (ej. `/subcomite/mi-subcomite-slug`).
* **Descripción:** El método `showPublic($slug)` busca un subcomité por su `slug`. Luego, obtiene todos los `DocumentoSubcomite` asociados y los pasa a la vista de detalle (`panel-subcomites.showPublic`), agrupados por año y tipo de documento.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\SubcomiteController.php`.
* **Modelos:**
    * `App\Models\Subcomite.php`: Representa a un subcomité. Define una relación `belongsTo` con `PlanEstatal`.
    * `App\Models\PlanEstatal.php`: Se usa para obtener la lista de planes a los que se puede asociar un subcomité.
    * `App\Models\DocumentoSubcomite.php`: Se utiliza para obtener los documentos en la página de detalle pública.
* **Trait:** `App\Traits\UpdatesPublicado`.
* **Vistas (Blade):**
    * `resources/views/panel-subcomites/index.blade.php`.
    * `resources/views/panel-subcomites/crear.blade.php`.
    * `resources/views/panel-subcomites/editar.blade.php`.
    * `resources/views/subcomites.blade.php` (Vista de listado público).
    * `resources/views/panel-subcomites/showPublic.blade.php` (Vista de detalle público).

## 4. Lógica de Negocio y Reglas Importantes

* **Generación de Slugs Únicos:** El controlador tiene un método privado `generateSlug` que crea una URL amigable a partir del nombre del subcomité. Si el `slug` ya existe, le añade un sufijo numérico incremental para garantizar su unicidad (`mi-slug`, `mi-slug-1`, etc.).
* **Gestión de Doble Imagen:** Cada registro gestiona dos archivos de imagen distintos: `conformacion` e `icono`.
* **Almacenamiento de Archivos:**
    * Las imágenes de "conformación" se guardan en `public/subcomitesconformacion/`.
    * Las imágenes de "ícono" se guardan en `public/icono_subcomites/`.
* **Valores Fijos:** Los tipos de subcomité (`Sectoriales`, `Especiales`, `Regional`) y el nombre del plan de desarrollo actual están definidos directamente en el controlador.
* **Relaciones:** Es mandatorio que cada `Subcomite` pertenezca a un `PlanEstatal`. La vista de detalle depende de la relación con `DocumentoSubcomite`.