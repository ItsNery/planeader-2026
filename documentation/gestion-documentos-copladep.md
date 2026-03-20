# Funcionalidad: Gestión de Documentos COPLADEP

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Esta sección del sistema permite a los administradores gestionar los documentos oficiales del Comité de Planeación para el Desarrollo del Estado de Puebla (COPLADEP). La funcionalidad permite subir, clasificar y publicar documentos en formato PDF, agrupándolos por año y tipo de documento para su visualización en una página pública.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Documentos (Admin)
* **Ruta principal:** `GET /panel-documentoscopladep` (asociada a la ruta `panel-documentoscopladep.index`).
* **Descripción:** Muestra una tabla con todos los documentos COPLADEP, ordenados por año y fecha de creación de forma descendente.

### b. Creación de un Nuevo Documento
1.  El administrador accede a la ruta `GET /panel-documentoscopladep/create` (ruta `panel-documentoscopladep.crear`).
2.  Se muestra un formulario para introducir el nombre, año, tipo de documento y el archivo PDF.
3.  La petición se envía a `POST /panel-documentoscopladep` (ruta `panel-documentoscopladep.store`).
4.  El sistema valida los datos, guarda el archivo PDF en el servidor y crea el registro en la base de datos.
5.  Finalmente, redirige al listado principal con un mensaje de éxito.

### c. Edición de un Documento
1.  El administrador accede a la ruta `GET /panel-documentoscopladep/{id}/edit`.
2.  Se muestra el formulario con los datos del documento ya cargados.
3.  La petición de actualización se envía a `PUT/PATCH /panel-documentoscopladep/{id}`.
4.  El sistema actualiza los datos. Si se sube un nuevo archivo PDF, reemplaza al anterior, eliminando el antiguo del servidor.

### d. Eliminación de un Documento
1.  La petición se envía a `DELETE /panel-documentoscopladep/{id}`.
2.  El sistema busca el documento, elimina el archivo PDF asociado del servidor y luego borra el registro de la base de datos.

### e. Actualización Rápida de Estado (Publicado/No Publicado)
* **Descripción:** El controlador utiliza el Trait `UpdatesPublicado`. Esto sugiere que existe una funcionalidad (probablemente en la vista de listado) para cambiar el estado de un documento de "Publicado" a "No Publicado" y viceversa de forma rápida, sin tener que entrar al formulario de edición.

### f. Listado Público de Documentos
* **Ruta:** No definida explícitamente, pero asociada al método `mostrarDocumentosCopladep`.
* **Descripción:** Existe una vista pública (`copladep.blade.php`) que muestra todos los documentos con estado "Publicado". Los documentos se agrupan por año y, dentro de cada año, se sub-agrupan por tipo de documento para facilitar la navegación del usuario final.

## 3. Componentes Técnicos Clave

* **Rutas:** Definidas probablemente como un Recurso de Laravel en `routes/web.php` bajo el nombre `panel-documentoscopladep`, además de rutas personalizadas para `mostrarDocumentosCopladep` y la funcionalidad del trait.
* **Controlador:** `App\Http\Controllers\DocumentoCopladepController.php`.
* **Modelo:** `App\Models\DocumentoCopladep.php`.
* **Trait:** `App\Traits\UpdatesPublicado`. Este componente encapsula la lógica para actualizar el campo booleano `publicado`.
* **Vistas (Blade):**
    * `resources/views/panel-documentoscopladep/index.blade.php`
    * `resources/views/panel-documentoscopladep/crear.blade.php`
    * `resources/views/panel-documentoscopladep/editar.blade.php`
    * `resources/views/copladep.blade.php` (Vista pública)

## 4. Lógica de Negocio y Reglas Importantes

* **Almacenamiento de Archivos:** Los documentos PDF se guardan en la carpeta `public/documentocopladep/`.
* **Validación de Archivos:** Solo se permiten archivos con extensión `.pdf`.
* **Validación de Año:** El año es un campo numérico de 4 dígitos, con un valor mínimo de 2010 y un máximo de 2025.
* **Valores Fijos:** Los tipos de documento (`Informe`, `Acta`, `Programa`) están definidos directamente en los métodos `create` y `edit` del controlador.
* **Lógica Condicional:** Al actualizar un documento, si el `tipo_documento` seleccionado es diferente de "Acta", el campo `tipo_acta` se establece automáticamente en `null`.
* **Campo `publicado`:** Este campo booleano controla la visibilidad de un documento en la página pública. Se gestiona tanto en la creación/edición como a través del Trait `UpdatesPublicado`.