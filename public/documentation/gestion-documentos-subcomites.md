# Funcionalidad: Gestión de Documentos de Subcomités

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Esta sección del sistema está diseñada para administrar los documentos pertenecientes a los diversos Subcomités. Permite a los usuarios crear, leer, actualizar y eliminar (CRUD) documentos en formato PDF, asociando cada uno a un Subcomité específico y clasificándolos por nombre, año y tipo de documento. También gestiona la visibilidad pública de dichos documentos.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Documentos (Admin)
* **Ruta principal:** `GET /panel-documentossubcomites` (asociada a la ruta `panel-documentossubcomites.index`).
* **Descripción:** Muestra una tabla con todos los documentos de los subcomités. Los registros se ordenan por año y fecha de creación de forma descendente y se paginan cada 1000 resultados.

### b. Creación de un Nuevo Documento
1.  Un administrador accede a `GET /panel-documentossubcomites/create`.
2.  El sistema carga los tipos de documento y un listado de todos los Subcomités disponibles (agrupados por `planestatal_id`) para mostrarlos en los selectores del formulario.
3.  La petición con los datos y el archivo se envía a `POST /panel-documentossubcomites`.
4.  Tras una validación exitosa, el sistema guarda el archivo PDF y crea el registro del documento en la base de datos, asociándolo al Subcomité seleccionado.

### c. Edición de un Documento
1.  Se accede al formulario de edición a través de la ruta `GET /panel-documentossubcomites/{id}/edit`.
2.  La petición de actualización se envía a `PUT/PATCH /panel-documentossubcomites/{id}`.
3.  El sistema valida los datos y actualiza el registro. Si se proporciona un nuevo archivo PDF, el antiguo es eliminado del servidor y reemplazado por el nuevo.

### d. Eliminación de un Documento
1.  La petición se envía a `DELETE /panel-documentossubcomites/{id}`.
2.  El sistema localiza el documento, elimina el archivo PDF asociado de la carpeta `public/documentosubcomites/` y luego borra el registro de la base de datos.

### e. Actualización Rápida de Estado (Publicado/No Publicado)
* **Descripción:** El controlador define un método explícito `updatePublicado` y también utiliza el Trait `UpdatesPublicado`. Esto permite cambiar el estado de publicación de un documento (probablemente desde un interruptor en la vista de listado) de forma rápida.

## 3. Componentes Técnicos Clave

* **Rutas:** Se definen como un Recurso de Laravel en `routes/web.php` bajo el nombre `panel-documentossubcomites`.
* **Controlador:** `App\Http\Controllers\DocumentoSubcomiteController.php`.
* **Modelos:**
    * `App\Models\DocumentoSubcomite.php`: Representa un documento. Define la tabla `documentosSubcomites` y tiene una relación `belongsTo` con el modelo `Subcomite`.
    * `App\Models\Subcomite.php`: Usado para obtener la lista de subcomités a los que se puede asociar un documento.
* **Trait:** `App\Traits\UpdatesPublicado`.
* **Vistas (Blade):**
    * `resources/views/panel-documentossubcomites/index.blade.php`.
    * `resources/views/panel-documentossubcomites/crear.blade.php`.
    * `resources/views/panel-documentossubcomites/editar.blade.php`.

## 4. Lógica de Negocio y Reglas Importantes

* **Almacenamiento de Archivos:** Los documentos PDF se guardan en la carpeta `public/documentosubcomites/`.
* **Validación:**
    * Los campos `nombre`, `anio`, `ruta_documento` (solo en creación), `subcomite_id` y `tipo_documento` son obligatorios.
    * El `anio` debe ser un número de 4 dígitos entre 2010 y 2025.
    * El archivo debe ser de tipo `pdf`.
* **Generación de Nombres de Archivo:** El nombre del archivo se sanitiza para reemplazar espacios y acentos, y se le añade el año y un timestamp para asegurar que sea único.
* **Valores Fijos:** Los tipos de documento (`Informe`, `Acta`, `Programa`) están definidos directamente en el controlador.
* **Lógica Condicional:** Al actualizar, si el `tipo_documento` se cambia a algo diferente de "Acta", el campo `tipo_acta` se establece automáticamente en `null`.
* **Relaciones:** Es mandatorio que cada `DocumentoSubcomite` pertenezca a un `Subcomite`.