# COPLADEP: QR, Check-in y Documento de Asistencia

## Objetivo

Cada registro COPLADEP toma la modalidad asignada a la persona invitada:

- `presencial`: genera un documento PDF con un boleto QR para el check-in.
- `virtual`: genera un documento PDF con la indicacion de conexion virtual.
- sin modalidad: el registro se guarda, pero no se genera documento.

La liga de Zoom o Meet se deja intencionalmente vacia por ahora. El documento virtual muestra que la liga se compartira proximamente.

## Datos almacenados

La migracion `2026_10_28_120000_add_modalidad_and_qr_to_copladep_tables.php` agrega:

### `invitado_copladeps`

| Campo | Uso |
| --- | --- |
| `modalidad` | Valor opcional: `presencial` o `virtual`. Define el documento que recibira el asistente. |

### `registro_copladeps`

| Campo | Uso |
| --- | --- |
| `modalidad` | Copia de la modalidad de la invitacion al momento de registrarse. Conserva el historial aunque la invitacion cambie despues. |
| `token_qr` | Token aleatorio de 64 caracteres para los registros presenciales. |
| `qr_path` | Ruta privada del PNG QR generado. |
| `check_in_at` | Fecha y hora del primer check-in valido. |

Para asignar modalidad a invitaciones existentes, use uno de estos valores:

```sql
UPDATE invitado_copladeps
SET modalidad = 'presencial'
WHERE sesion = 'segunda';
```

```sql
UPDATE invitado_copladeps
SET modalidad = 'virtual'
WHERE id = 123;
```

## Registro publico

El formulario publico no permite que la persona elija su modalidad. La modalidad se toma de la invitacion seleccionada, por lo que no se puede obtener un QR presencial alterando el formulario.

Al enviar el formulario, `RegistroCopladepController::store()` realiza estas acciones:

1. Comprueba que el periodo de registro este abierto.
2. Valida que la invitacion pertenezca a la sesion seleccionada.
3. Evita duplicados por nombre y correo dentro de la misma sesion.
4. Lee la modalidad de `invitado_copladeps`.
5. Crea el registro con una copia de esa modalidad.
6. Si es presencial, genera un token QR aleatorio y guarda su imagen PNG en el disco local.
7. Si es virtual o presencial, redirige a la confirmacion y descarga el PDF automaticamente.
8. Si no tiene modalidad, redirige al formulario con un aviso y no expone ninguna descarga.

El formulario muestra un aviso al seleccionar a una persona cuya modalidad aun no esta definida.

## Documento PDF

La descarga se atiende en:

```text
GET /copladep/registro/{identificador}/pdf
```

El identificador es el token QR para asistencia presencial o el identificador interno del registro para asistencia virtual.

Para las sesiones que no tienen una convocatoria personalizada, el PDF final se arma con FPDI a partir de dos documentos DomPDF:

| Pagina | Tamano | Contenido |
| --- | --- | --- |
| 1 | Boleto, 80 x 150 mm | Nombre, modalidad y QR presencial; o informacion de conexion virtual. |
| 2 | Carta | Ficha del evento: fecha, hora, sede, asistente y modalidad. |
| 3 | Carta | Orden del dia. |

La Segunda Sesión Ordinaria 2026 usa una sola página diseñada por Comunicación:

- `public/sesiones-copladep/segunda-2026/CONVOC_2.PDF`: asistencia presencial; el QR se inserta sobre el área marcada.
- `public/sesiones-copladep/segunda-2026/CONVOC_1.PDF`: asistencia virtual; la liga de Meet se inserta sobre el área marcada y queda como hipervínculo.

La liga se configura en el campo **Enlace virtual** de la sesión desde el panel administrativo. Mientras esté vacía, el documento indica que se compartirá próximamente.

## Codigo QR

`CopladepQrService` crea tokens criptograficamente aleatorios y genera el PNG mediante Endroid QR Code.

El contenido del QR sigue este formato:

```text
COPLADEP{YY}:{clave-de-sesion}:{token}
```

Ejemplo:

```text
COPLADEP26:2026-segunda-ordinaria:8e9d...
```

El PNG se guarda en almacenamiento privado bajo:

```text
storage/app/private/qr-copladep/{clave-de-sesion}/{token}.png
```

No se publica directamente en `public`, por lo que el QR solo se obtiene a traves del documento que se descarga tras el registro.

## Check-in administrativo

Desde cada listado de registros se muestra el boton **Check-in QR**. Abre:

```text
GET /copladep/{sesion}/scanner
```

La vista usa la camara mediante `html5-qrcode` y tambien acepta captura manual del codigo. Al leerlo, envia una solicitud autenticada a:

```text
POST /copladep/{sesion}/scanner/checkin
```

El servidor:

1. Extrae y valida el token del formato QR.
2. Busca el registro dentro de la sesion indicada.
3. Rechaza QR inexistentes, virtuales o usados previamente.
4. Guarda `check_in_at` una unica vez.
5. Devuelve el nombre de la persona confirmada.

Las rutas de escaneo requieren el permiso existente `ver-listado-registro-copladep` y autenticacion.

## Dependencias

Se agregaron al proyecto:

- `barryvdh/laravel-dompdf`: renderiza las paginas del documento.
- `endroid/qr-code`: genera el QR PNG.
- `setasign/fpdf` y `setasign/fpdi`: unen la pagina boleto y las paginas carta conservando sus diferentes dimensiones.

## Rutas nuevas

| Metodo | Ruta | Nombre |
| --- | --- | --- |
| GET | `/copladep/registro/{identificador}/confirmacion` | `copladep-registro.confirmacion` |
| GET | `/copladep/registro/{identificador}/pdf` | `copladep-registro.pdf` |
| GET | `/copladep/{sesion}/scanner` | `copladep-registro.scanner` |
| POST | `/copladep/{sesion}/scanner/checkin` | `copladep-registro.checkin` |

## Despliegue

En servidores donde aun no se ha actualizado la base de datos, ejecutar:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
```

Antes de abrir el registro, cargar la modalidad de cada invitacion. Mientras `modalidad` sea `NULL`, el sistema conserva el registro, pero deliberadamente no emite el PDF.
