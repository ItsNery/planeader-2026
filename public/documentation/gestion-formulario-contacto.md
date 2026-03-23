# Funcionalidad: Formulario de Contacto

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo proporciona un formulario de contacto para que los visitantes del sitio web puedan enviar mensajes. El sistema captura los datos del remitente, valida la entrada para prevenir spam mediante Google reCAPTCHA y almacena los mensajes en la base de datos para su posterior revisión por parte de los administradores.

## 2. Flujo Principal y Casos de Uso

### a. Envío de un Mensaje (Flujo Público)
1.  Un usuario accede a la página de contacto y llena el formulario con su nombre, correo, teléfono, asunto y mensaje.
2.  El usuario debe completar la validación de Google reCAPTCHA.
3.  La petición se envía vía `POST` al endpoint manejado por el método `store`.
4.  El sistema valida todos los campos, incluido el reCAPTCHA. Si la validación es exitosa, se guarda el mensaje en la base de datos.
5.  El usuario es redirigido de vuelta a la página de contacto con un mensaje de éxito.

### b. Listado de Mensajes (Panel de Administración)
* **Ruta principal:** Asociada al nombre de ruta `formulariocontacto.index`.
* **Descripción:** Un administrador accede a una vista (`panel-contacto.index`) que muestra todos los mensajes recibidos, paginados cada 1000 registros.

### c. Eliminación de un Mensaje (Panel de Administración)
1.  Desde el listado de mensajes, un administrador puede eliminar un mensaje específico.
2.  La petición se envía a la ruta `DELETE` manejada por el método `destroy`.
3.  El sistema busca el mensaje por su ID, lo elimina de la base de datos y redirige al administrador de vuelta al listado con un mensaje de éxito.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\FormularioContactoController.php`.
* **Modelo:** `App\Models\FormularioContacto.php`.
    * La tabla asociada en la base de datos es `formularioscontacto`.
    * Los campos `fillable` son `nombre`, `correo`, `telefono`, `asunto`, `mensaje`.
* **Vistas (Blade):**
    * `resources/views/panel-contacto/index.blade.php`.
* **Dependencias Externas:** La funcionalidad depende de un paquete de Google reCAPTCHA para la validación `captcha`.

## 4. Lógica de Negocio y Reglas Importantes

* **Validación:**
    * Todos los campos del formulario son obligatorios.
    * El campo `correo` debe tener un formato de email válido.
    * El `telefono` no puede exceder los 15 caracteres y el `mensaje` tiene un límite de 350 caracteres.
* **Seguridad:** La validación del `g-recaptcha-response` es obligatoria para prevenir el envío de spam por parte de bots.
* **Gestión de Mensajes:** El panel de administración permite listar y eliminar mensajes. No existe la funcionalidad para editar los mensajes recibidos, ya que los métodos `edit` y `update` están vacíos.