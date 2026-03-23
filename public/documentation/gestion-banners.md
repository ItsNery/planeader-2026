# Funcionalidad: Gestión de Banners

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Esta sección del sistema permite a los administradores gestionar los banners que se muestran en las diferentes partes del sitio web. Abarca la creación, visualización, actualización y eliminación (CRUD) de los banners.

## 2. Flujo Principal y Casos de Uso

### a. Listado de Banners
- **Ruta principal:** `GET /panel-banners` (asociada al nombre de ruta `panel-banners.index`).
- **Descripción:** Muestra una tabla con todos los banners existentes, paginados de a 1000 registros. Ofrece botones para editar y eliminar cada banner.

### b. Creación de un Nuevo Banner
1.  El administrador hace clic en el botón "subir nuevo".
2.  Se le redirige a la ruta `GET /panel-banners/create` (ruta `panel-banners.crear`) que muestra un formulario.
3.  El administrador llena los campos (nombre, descripción, sube una imagen, etc.) y hace clic en "Guardar".
4.  La petición se envía a `POST /panel-banners` (ruta `panel-banners.store`).
5.  Si la validación es correcta, el banner se guarda en la base de datos y el administrador es redirigido al listado principal con un mensaje de éxito.

### c. Edición de un Banner Existente
1.  En el listado, el administrador hace clic en "Editar" en la fila de un banner.
2.  Se le redirige a `GET /panel-banners/{id}/edit` (ruta `panel-banners.edit`) que muestra el formulario con los datos del banner ya cargados.
3.  El administrador modifica los datos y hace clic en "Actualizar".
4.  La petición se envía a `PUT/PATCH /panel-banners/{id}` (ruta `panel-banners.update`).
5.  Si la validación es correcta, los cambios se guardan y se redirige al listado con un mensaje de éxito.

### d. Eliminación de un Banner
1.  En el listado, el administrador hace clic en "Eliminar".
2.  La petición se envía a `DELETE /panel-banners/{id}` (ruta `panel-banners.destroy`).
3.  El banner se elimina de la base de datos y de la carpeta de imágenes, y se redirige al listado.

## 3. Componentes Técnicos Clave

* **Rutas:** Las rutas se definen como un Recurso de Laravel en `routes/web.php` bajo el nombre `panel-banners`.
* **Controlador:** `App\Http\Controllers\BannerController.php`.
* **Modelo:** `App\Models\Banner.php`.
* **Form Requests (Validación):** No se utilizan Form Requests. La validación se realiza directamente en los métodos `store` y `update` del controlador usando `$this->validate()`.
* **Vistas (Blade):**
    * `resources/views/panel-banners/index.blade.php`.
    * `resources/views/panel-banners/crear.blade.php`.
    * `resources/views/panel-banners/editar.blade.php`.

## 4. Lógica de Negocio y Reglas Importantes

* **Validación de Campos:**
    * `nombre`: Requerido, máximo 60 caracteres.
    * `descripcion`: Requerido, máximo 120 caracteres.
    * `enlace`: Requerido. Se instruye al usuario a colocar "#" si no hay un enlace real.
    * `imagen`: Requerida en la creación, opcional en la actualización. Debe ser una imagen (`jpeg`, `png`, `svg`, `jpg`) y no pesar más de 6MB (6144 KB).
* **Valores Fijos:**
    * Los valores para el campo `estado` están definidos en el controlador: `['Activo', 'Inactivo', 'Pendiente']`.
    * Los valores para el campo `seccion` están definidos en el controlador: `['Inicio', 'COPLADEP', 'Programas Derivados', 'Plan Estatal']`.
* **Almacenamiento de Archivos:** Las imágenes se guardan en la carpeta `public/baners/`. El nombre del archivo se genera con el "slug" del nombre del banner más la fecha y hora para evitar colisiones.
* **Gestión del Orden:** El controlador calcula los números de orden disponibles y los pasa a las vistas de creación y edición para ser seleccionados.
* **Autorización:** No se observa un middleware de autorización explícito en los métodos del controlador. Es posible que se esté aplicando a nivel de las rutas en `routes/web.php`.