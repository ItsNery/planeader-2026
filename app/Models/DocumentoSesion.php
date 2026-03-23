<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad DocumentoSesion.
 * Representa un documento de una sesión del COPLADEP.
 *
 * @property int $id
 * @property string $nombre
 * @property string $ruta_documento
 * @property string|null $portada
 * @property int $orden
 * @property string $sesion
 * @property bool $publicado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class DocumentoSesion extends Model
{
    use HasFactory;

    protected $table = 'documentos_sesiones';

    protected $fillable = [
        'nombre',
        'ruta_documento',
        'portada',
        'orden',
        'sesion',
        'publicado'
    ];
}
