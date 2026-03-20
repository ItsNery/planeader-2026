# Funcionalidad: Encuesta de Satisfacción

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Esta funcionalidad permite recolectar las respuestas de los usuarios a una encuesta de satisfacción simple directamente desde el sitio web. El objetivo es guardar la opinión del usuario (un valor numérico) en la base de datos para su posterior análisis.

## 2. Flujo Principal y Casos de Uso

El controlador expone un único flujo de trabajo a través de un método personalizado.

### a. Guardar Respuesta de la Encuesta
1.  Un usuario interactúa con un formulario de encuesta en alguna página pública del sitio.
2.  Al enviar su respuesta, se realiza una petición (probablemente vía AJAX/JavaScript) a un endpoint manejado por el método `guardarRespuesta`.
3.  El sistema valida que la respuesta sea un valor válido ('1', '2', o '3').
4.  Si la validación es exitosa, se crea un nuevo registro en la tabla `encuestas` con la respuesta del usuario.
5.  El sistema devuelve una respuesta en formato JSON para indicar que la operación fue exitosa (`{'success': true}`). No hay redirección, lo que confirma que está diseñado para ser consumido por JavaScript.

## 3. Componentes Técnicos Clave

* **Ruta:** No se define en los archivos, pero existe una ruta (probablemente `POST`) que apunta al método `guardarRespuesta` del `EncuestaController`.
* **Controlador:** `App\Http\Controllers\EncuestaController.php`.
* **Modelo:** `App\Models\Encuesta.php`.
    * Los campos `fillable` son `['satisfaccion']`.
* **Vistas (Blade):** No se utiliza ninguna vista de Blade en este controlador. La interacción es a través de una respuesta JSON.

## 4. Lógica de Negocio y Reglas Importantes

* **Validación:** La entrada para `satisfaccion` es obligatoria y debe ser uno de los siguientes valores: `1`, `2`, o `3`.
* **Sin Interfaz de Administración:** El `EncuestaController` proporcionado no contiene métodos para listar, editar o eliminar respuestas (`index`, `edit`, `destroy`, etc., están vacíos). Se puede consultar la gráfica de satisfacción del sitio en el dashboard.