<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad DocumentoCopladep.
 * Representa a un documento del Copladep de la página de Copladep del sistema.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento.
 * @property string $anio El año del banner (INT, obligatorio).
 * @property string $nombre El nombre del banner (VARCHAR, obligatorio).
 * @property string $ruta_documento La ruta del documento  del banner (VARCHAR, obligatorio).
 * @property string $tipo_documento El tipo de documento (VARCHAR, obligatorio).
 * @property string $tipo_acta El tipo de acta, si lo fuera. (VARCHAR, nulo).
 * @property bool $publicado Indica si el documento está publicado (BOOLEAN, obligatorio).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class DocumentoCopladep extends Model
{
    use HasFactory;
    /**
     * El nombre de la tabla donde se guardan los registros.
     *
     * @var string
     */

    protected $table = 'documentos_copladep';
    
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'anio', 'ruta_documento', 'tipo_documento', 'tipo_acta', 'publicado'];
}
