# Funcionalidad: Gestión de Programas Estatales

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo administra los "Programas Estatales". Permite a los administradores subir un documento PDF y una imagen de portada para cada programa. Cada programa debe estar asociado a un `PlanEstatal`, lo que permite al sistema clasificarlo automáticamente como un programa actual o histórico.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Programas (Admin)
* **Ruta principal:** Asociada al nombre de ruta `panel-programasEstatales.index`.
* **Descripción:** Muestra un listado de todos los programas estatales para su gestión.

### b. Creación de un Nuevo Programa
1.  Un administrador accede al formulario de creación a través del método `create`, que carga previamente todos los Planes Estatales disponibles.
2.  La petición con los datos y archivos se envía al método `store`.
3.  El sistema valida los datos. Luego, determina si el programa es "histórico" comparando el ID del Plan Estatal seleccionado con el del plan más reciente.
4.  Se guardan los archivos en el servidor y se crea el registro del programa en la base de datos con el indicador de `historico` ya establecido.

### c. Edición de un Programa
1.  Se accede al formulario de edición a través del método `edit`, que busca el programa por su ID.
2.  La petición de actualización se envía al método `update`.
3.  El sistema actualiza los datos y vuelve a evaluar el campo `historico` basado en el Plan Estatal seleccionado. Si se suben nuevos archivos, los anteriores son eliminados del servidor y reemplazados.

### d. Eliminación de un Programa
1.  La petición de borrado se envía al método `destroy`.
2.  El sistema elimina ambos archivos asociados (el documento PDF de `programasEstatales/` y la portada de `img/portadas-programas-estatales/`).
3.  Posteriormente, elimina el registro de la base de datos.

### e. Actualización Rápida de Estado (Publicado/No Publicado)
* **Descripción:** El controlador utiliza el Trait `UpdatesPublicado`, lo que indica que existe una funcionalidad para cambiar rápidamente el estado de publicación de un programa.

### f. Listado Público de Programas
* **Descripción:** El método `mostrarProgramasEstatales` se encarga de la vista pública (`programas-estatales`). Obtiene todos los programas publicados y los separa en dos colecciones: los actuales (`historico` = 0) y los históricos (`historico` = 1). Los programas históricos son agrupados por el Plan Estatal al que pertenecen para su correcta visualización.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\ProgramaEstatalController.php`.
* **Modelos:**
    * `App\Models\ProgramaEstatal.php`: Representa un programa estatal. Define una relación `belongsTo` con el modelo `PlanEstatal`.
    * `App\Models\PlanEstatal.php`: Se usa para obtener la lista de planes a los que se puede asociar un programa.
* **Trait:** `App\Traits\UpdatesPublicado`.
* **Vistas (Blade):**
    * `resources/views/panel-programasEstatales/index.blade.php`.
    * `resources/views/panel-programasEstatales/crear.blade.php`.
    * `resources/views/panel-programasEstatales/editar.blade.php`.
    * `resources/views/programas-estatales.blade.php` (Vista pública).

## 4. Lógica de Negocio y Reglas Importantes

* **Lógica de "Histórico":** La principal regla de negocio es la clasificación automática de un programa como "histórico". Un programa se considera actual (`historico` = 0) solo si está asociado al `PlanEstatal` más reciente (ordenado por `periodo` descendente). En cualquier otro caso, se marca como histórico (`historico` = 1).
* **Gestión de Doble Archivo:** Cada registro gestiona dos archivos: el documento principal (PDF) y una imagen de portada.
* **Almacenamiento de Archivos:**
    * Los documentos PDF se guardan en la carpeta `public/programasEstatales/`.
    * Las imágenes de portada se guardan en la carpeta `public/img/portadas-programas-estatales/`.
* **Validación:** En la creación, son obligatorios el nombre, el documento PDF, la portada y la asociación a un Plan Estatal.
* **Relaciones:** Es mandatorio que cada `ProgramaEstatal` pertenezca a un `PlanEstatal`.