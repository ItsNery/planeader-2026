# Funcionalidad: Gestión de Programas Derivados

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo permite a los administradores gestionar los "Programas Derivados" que se originan a partir de un "Plan Estatal de Desarrollo". La funcionalidad consiste en subir un documento PDF y una imagen de portada para cada programa, clasificarlo por tipo y asociarlo a un Plan Estatal principal.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Programas (Admin)
* **Ruta principal:** Asociada al nombre de ruta `panel-programasderivados.index`.
* **Descripción:** Muestra una tabla con todos los programas derivados para su gestión, con una paginación de 1000 registros por página.

### b. Creación de un Nuevo Programa
1.  Un administrador accede al formulario de creación a través del método `create`, que carga previamente los tipos de programas y los Planes Estatales disponibles.
2.  La petición con los datos y archivos se envía al método `store`.
3.  El sistema valida los datos, incluyendo el tipo de programa y su asociación a un Plan Estatal. Si la validación es correcta, los archivos se guardan y se crea el registro.

### c. Edición de un Programa
1.  Se accede al formulario de edición a través del método `edit`, que busca el programa por su ID y carga los datos necesarios para los selectores del formulario.
2.  La petición de actualización se envía al método `update`.
3.  El sistema actualiza los datos del programa. Si se suben nuevos archivos (documento o portada), los anteriores son eliminados del servidor y reemplazados.

### d. Eliminación de un Programa
1.  La petición de borrado se envía al método `destroy`.
2.  El sistema elimina ambos archivos asociados (el documento PDF de la carpeta `progderi/` y la portada de `portadaprogder/`).
3.  Posteriormente, elimina el registro de la base de datos.

### e. Actualización Rápida de Estado (Publicado/No Publicado)
* **Descripción:** El controlador utiliza el Trait `UpdatesPublicado`, lo que indica que existe una funcionalidad para cambiar rápidamente el estado de publicación de un programa.

### f. Listado Público de Programas
* **Descripción:** El método `mostrarProgramasDerivados` tiene una lógica compleja para la vista pública (`programaderivados`):
    * Separa los programas en dos grupos: "históricos" y "actuales". Los "actuales" son aquellos que pertenecen al 'Plan Estatal de Desarrollo 2024-2030' (Este se defne manualmente).
    * Filtra para mostrar solo los programas publicados (`publicado` = 1) en ambos grupos.
    * Los programas actuales se agrupan por `tipo_derivado` y se ordenan de forma personalizada (Sectoriales, Especiales, Regionales, Institucionales).
    * Calcula y pasa a la vista la fecha de última actualización para cada uno de los dos grupos.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\ProgramaDerivadoController.php`.
* **Modelos:**
    * `App\Models\ProgramaDerivado.php`: Representa un programa derivado. Tiene una relación `belongsTo` con el modelo `PlanEstatal`.
    * `App\Models\PlanEstatal.php`: Se usa para obtener la lista de planes a los que se puede asociar un programa.
* **Trait:** `App\Traits\UpdatesPublicado`.
* **Vistas (Blade):**
    * `resources/views/panel-programasderivados/index.blade.php`.
    * `resources/views/panel-programasderivados/crear.blade.php`.
    * `resources/views/panel-programasderivados/editar.blade.php`.
    * `resources/views/programaderivados.blade.php` (Vista pública).

## 4. Lógica de Negocio y Reglas Importantes

* **Gestión de Doble Archivo:** Cada registro gestiona dos archivos: el documento principal (PDF) y una imagen de portada.
* **Almacenamiento de Archivos:**
    * Los documentos PDF se guardan en la carpeta `public/progderi/`.
    * Las imágenes de portada se guardan en la carpeta `public/portadaprogder/`.
* **Validación:** En la creación, son obligatorios el nombre, el documento PDF, la portada, el tipo de derivado y la asociación a un Plan Estatal.
* **Valores Fijos:** Los tipos de programas derivados (`Sectoriales`, `Especiales`, `Institucionales`, `Regionales`) están definidos directamente en el controlador.
* **Relaciones:** Es mandatorio que cada `ProgramaDerivado` pertenezca a un `PlanEstatal`.