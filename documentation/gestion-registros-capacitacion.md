# Funcionalidad: Registro a Capacitación Municipal

**Autor:** Nery Pozos Moreno
**Fecha de última actualización:** 2025-06-18

## 1. Propósito de la Funcionalidad

Este módulo gestiona el registro de participantes para un programa de capacitación municipal. Proporciona un formulario público para que los usuarios ingresen sus datos y un panel de administración para visualizar a los registrados, quienes son agrupados y filtrados por días específicos del evento.

## 2. Flujo Principal y Casos de Uso

### a. Registro de un Participante (Flujo Público)
1.  Un usuario accede al formulario de registro a través del método `create`, el cual carga un listado de municipios únicos para el selector.
2.  El usuario completa sus datos personales (nombre, sexo, cargo, municipio, etc.) y envía el formulario.
3.  La petición `POST` es manejada por el método `store`.
4.  El controlador utiliza `Validator::make()` para una validación manual y detallada de los datos.
5.  Si la validación es exitosa, se intenta crear el registro dentro de un bloque `try-catch` para manejar posibles errores de base de datos.
6.  El usuario es redirigido de vuelta al formulario de registro con un mensaje de éxito o de error, según corresponda.

### b. Listado de Participantes (Panel de Administración)
* **Ruta principal:** Asociada al método `index` del `RegistroController`.
* **Descripción:** Este panel tiene una lógica de negocio muy específica. En lugar de mostrar todos los registros, los filtra y agrupa en tres colecciones separadas (`registrosDia1`, `registrosDia2`, `registrosDia3`) basadas en rangos de fecha y hora fijos correspondientes a un evento de capacitación en mayo del año en curso.
* **Vista:** Los tres grupos de registros se envían a la vista `registro-coplademun-listado`, que probablemente los muestra en pestañas o secciones separadas.

## 3. Componentes Técnicos Clave

* **Controlador:** `App\Http\Controllers\RegistroController.php`.
* **Modelos:**
    * `App\Models\RegistroCapacitacion.php`: Representa el registro de un participante. Define la tabla `registro_capacitacions` y tiene una relación `belongsTo` con `CatMunicipio`.
    * `App\Models\CatMunicipio.php`: Se usa para obtener el catálogo de municipios para el formulario.
* **Facades Notables:**
    * `Illuminate\Support\Facades\Validator`: Usado para la validación manual.
    * `Illuminate\Support\Facades\Log`: Implementado extensivamente para registrar el flujo, los datos y los errores.
    * `Carbon\Carbon`: Utilizado para definir los rangos de fecha y hora para el filtrado en el panel de administración.
* **Vistas (Blade):**
    * `resources/views/registro-coplademun.blade.php` (Formulario de registro público).
    * `resources/views/registro-coplademun-listado.blade.php` (Panel de administración).

## 4. Lógica de Negocio y Reglas Importantes

* **Validación Manual:** A diferencia de otros módulos, este utiliza explícitamente `Validator::make()`. Esto permite un control más granular sobre las reglas, los mensajes de error personalizados y el flujo de redirección en caso de fallo.
* **Manejo Robusto de Errores:** El método `store` está envuelto en un bloque `try-catch` para capturar excepciones durante la inserción en la base de datos, previniendo fallos y registrando el error detallado para depuración.
* **Lógica de Agrupación por Fechas:** La característica principal del panel de administración (`index`) es su capacidad para segregar a los registrados en grupos de "Día 1", "Día 2" y "Día 3" basándose en la fecha y hora exactas en que se creó su registro (`created_at`). Los rangos están definidos de forma fija en el controlador.
* **Relaciones:** Cada `RegistroCapacitacion` debe pertenecer a un `CatMunicipio`.