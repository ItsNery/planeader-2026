# Guía de Uso: Insumos del Plan Estatal de Desarrollo

## 📋 Resumen de Implementación

Se ha creado un sistema completo para gestionar los insumos del PED con dos tipos de documentos:
- **Árboles de Problemas**
- **Fichas de Indicadores**

---

## 🔧 Acceso al Panel Administrativo

### URL del CRUD:
```
http://localhost/laragon/www/planeader/panel-documentos-insumo-ped
```

### Funcionalidades del Panel:
- **Ver documentos**: Tabla con todos los documentos registrados
- **Crear documento**: Botón "Subir documento" en la esquina superior derecha
- **Editar documento**: Icono de lápiz en la fila del documento
- **Eliminar documento**: Icono de papelera (solo disponible para validadores)
- **Cambiar estado**: Dropdown "Publicado/Borrador" (solo para validadores)

---

## 📝 Campos del Formulario (CRUD)

### Información Principal:
1. **Título del documento** (texto, obligatorio)
   - Ejemplo: "Árbol de problemas del Eje 1"

2. **Tipo de documento** (selector, obligatorio)
   - Árbol de Problemas
   - Fichas de Indicadores

### Detalles del Archivo:
3. **Archivo** (PDF o Excel, obligatorio para crear)
   - Máximo 100 MB
   - El formato se detecta automáticamente:
     - `.pdf` → PDF
     - `.xls`, `.xlsx` → Excel

### Estado de Publicación:
4. **Publicar documento** (checkbox)
   - Activado por defecto
   - Si está activado, el documento es visible en la sección pública

---

## 🌐 Acceso Público (Sección Pública)

### URL de la página pública:
```
http://localhost/laragon/www/planeader/insumos-ped
```

### Características:
- Dos pestañas (tabs) principales:
  - **Árboles de Problemas**: Muestra todos los documentos de tipo "arbol-problemas" publicados
  - **Fichas de Indicadores**: Muestra todos los documentos de tipo "fichas-indicadores" publicados
- Cada documento se muestra en una tarjeta con:
  - Icono del tipo de archivo (PDF o Excel)
  - Título del documento
  - Formato y fecha de creación
  - Botón "Descargar"

### Integración en planestatal.blade.php:
Se agregó un nuevo botón junto al botón de "Consultar documento" que dice:
"**Consulta los insumos del PED**" y enlaza a la página pública de insumos.

---

## 🗄️ Estructura de Base de Datos

### Tabla: `documento_insumo_peds`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | BIGINT | Identificador único |
| `titulo` | VARCHAR(255) | Título del documento |
| `tipo` | ENUM | Tipo: 'arbol-problemas' o 'fichas-indicadores' |
| `ruta_documento` | VARCHAR(255) | Nombre del archivo guardado |
| `formato` | ENUM | Formato: 'pdf' o 'excel' |
| `publicado` | BOOLEAN | Estado de publicación (1=publicado, 0=borrador) |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Fecha de última actualización |

---

## 🔐 Permisos Requeridos

Los siguientes permisos están disponibles para control de acceso:
- `ver-documento-insumo-ped`: Ver listado
- `crear-documento-insumo-ped`: Crear documentos
- `editar-documento-insumo-ped`: Editar documentos
- `borrar-documento-insumo-ped`: Eliminar documentos

Todos los roles creados (super-admin, admin, editor) tienen estos permisos activados.

---

## 📁 Estructura de Archivos Creados

```
app/
├── Models/
│   └── DocumentoInsumoPed.php

app/Http/Controllers/
├── DocumentoInsumoPedController.php

database/
├── migrations/
│   └── 2026_05_25_000001_create_documento_insumo_peds_table.php

resources/views/
├── panel-documentos-insumo-ped/
│   ├── index.blade.php
│   └── form.blade.php
├── insumos-ped.blade.php
└── planestatal.blade.php (modificado)

public/
└── insumos-ped/  (directorio para almacenar documentos)

routes/
└── web.php (rutas agregadas)

database/seeders/
└── RolePermissionSeeder.php (actualizado)
```

---

## ⚙️ Rutas Disponibles

### Rutas Protegidas (Admin):
```
GET    /panel-documentos-insumo-ped              (index)
GET    /panel-documentos-insumo-ped/create       (form crear)
POST   /panel-documentos-insumo-ped              (store)
GET    /panel-documentos-insumo-ped/{id}/edit    (form editar)
PUT    /panel-documentos-insumo-ped/{id}         (update)
DELETE /panel-documentos-insumo-ped/{id}         (destroy)
PATCH  /documento-insumo-ped/{id}/publicado      (updatePublicado)
```

### Rutas Públicas:
```
GET    /insumos-ped    (vista pública con tabs)
```

---

## 💡 Notas Importantes

1. **Almacenamiento de archivos**: Los documentos se guardan en `public/insumos-ped/`
2. **Formato automático**: No necesitas seleccionar el formato, se detecta al subir el archivo
3. **Validaciones**:
   - El título es obligatorio
   - El tipo de documento es obligatorio
   - El archivo es obligatorio al crear, opcional al editar
   - El tamaño máximo es 100 MB
   - Solo se aceptan PDF y Excel

4. **Seguridad**: 
   - Solo usuarios autenticados pueden acceder al panel
   - Las operaciones de editar/eliminar están restringidas a usuarios con permisos
   - Los documentos que no están publicados no aparecen en la sección pública

---

## 🚀 Próximos Pasos (Opcional)

- Agregar búsqueda/filtro en el panel de documentos
- Agregar vista previa de documentos antes de descargar
- Implementar sincronización con SPED (Sistema de Información para el Seguimiento)
- Agregar estadísticas de descargas
