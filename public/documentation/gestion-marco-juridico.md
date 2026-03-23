# Funcionalidad: Gestión de Marco Jurídico

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo permite a los administradores gestionar los documentos de la sección "Marco Jurídico" del sitio web. La funcionalidad principal consiste en subir un documento en formato PDF junto con una imagen de portada asociada, asignarle un orden específico de aparición y controlar su visibilidad pública.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Documentos (Admin)
* **Ruta principal:** Asociada al nombre de ruta `panel-marcojuridico.index`.
* **Descripción:** Muestra una tabla con todos los documentos del marco jurídico, con una paginación de 1000 registros por página.

### b. Creación de un Nuevo Documento
1.  Un administrador accede al formulario de creación a través del método `create`. El sistema calcula previamente los números de orden disponibles para ofrecerlos en un selector.
2.  La petición con los datos (nombre, orden) y los archivos (PDF y portada) se envía al método `store`.
3.  El sistema valida los datos y los archivos, los guarda en sus respectivas carpetas en el servidor y crea el registro en la base de datos.
4.  Finalmente, redirige al listado principal con un mensaje de éxito.

### c. Edición de un Documento
1.  Se accede al formulario de edición a través del método `edit`, que busca el documento por su ID y carga los números de orden disponibles.
2.  La petición de actualización se envía al método `update`.
3.  El sistema valida los nuevos datos. Si se proporcionan nuevos archivos (documento o portada), estos reemplazan a los anteriores.

### d. Eliminación de un Documento
1.  La petición de borrado se envía al método `destroy`, que busca el documento por su ID.
2.  El sistema elimina ambos archivos asociados (el documento PDF y la imagen de portada) del servidor.
3.  Posteriormente, elimina el registro de la base de datos.

### e. Actualización Rápida de Estado (Publicado/No Publicado)
* **Descripción:** El controlador define un método `updatePublicado` que permite cambiar el estado de publicación de un documento a través de una petición que valida que el nuevo estado sea booleano.

### f. Listado Público de Documentos
* **Descripción:** El método `mostrarDocumentosMarco` se encarga de obtener todos los documentos marcados como publicados (`publicado` = 1). Los resultados se ordenan según el campo `orden` de forma ascendente y se muestran en la vista `marcojuridico`.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\MarcoJuridicoController.php`.
* **Modelo:** `App\Models\MarcoJuridico.php`.
    * La tabla asociada en la base de datos es `marcojuridico`.
    * Los campos `fillable` son `nombre`, `ruta_documento`, `portada`, y `orden`.
* **Vistas (Blade):**
    * `resources/views/panel-marcojuridico/index.blade.php`.
    * `resources/views/panel-marcojuridico/crear.blade.php`.
    * `resources/views/panel-marcojuridico/editar.blade.php`.
    * `resources/views/marcojuridico.blade.php` (Vista pública).

## 4. Lógica de Negocio y Reglas Importantes

* **Gestión de Doble Archivo:** Cada registro del Marco Jurídico gestiona dos archivos distintos: el documento principal (PDF) y una imagen de portada (`jpeg`, `png`, `svg`, `jpg`).
* **Almacenamiento de Archivos:**
    * Los documentos PDF se guardan en la carpeta `public/marco-juridico/`.
    * Las imágenes de portada se guardan en la carpeta `public/portadas-marcojuridico/`.
* **Validación:**
    * En la creación, el nombre, el documento PDF, la portada y el orden son obligatorios.
    * En la actualización, solo el nombre y el orden son obligatorios, permitiendo cambiar solo los datos sin necesidad de volver a subir los archivos.
    * El documento PDF tiene un límite de tamaño de 500MB y la portada de 6MB.
* **Sistema de Ordenamiento:** La funcionalidad incluye un sistema para definir manualmente el orden de aparición de los documentos en la vista pública. Los números de orden disponibles se calculan y se pasan a las vistas de creación y edición.
* **Generación de Nombres de Archivo:** Los nombres de los archivos se generan utilizando un "slug" del nombre del documento (limitado a 70 caracteres) seguido de un timestamp para asegurar que sean únicos.