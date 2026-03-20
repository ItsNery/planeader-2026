<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad DocumentoSubcomite.
 * Representa a un documento de cualquiera subcomité de la página de de detalle de cada uno.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento.
 * @property string $anio El año del documento (INT, obligatorio).
 * @property string $nombre El nombre del documento (VARCHAR, obligatorio).
 * @property string $ruta_documento La ruta del documento (VARCHAR, obligatorio).
 * @property string $tipo_documento El tipo de documento (VARCHAR, obligatorio).
 * @property string|null $tipo_acta El tipo de acta, si lo fuera (VARCHAR, nulo).
 * @property bool $publicado Indica si el documento está publicado (BOOLEAN, obligatorio).
 * @property int $subcomite_id El identificador del subcomité al que pertenece el documento (INT, obligatorio).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class DocumentoSubcomite extends Model
{
    use HasFactory;
    /**
     * El nombre de la tabla donde se guardan los registros.
     *
     * @var string
     */
    protected $table = 'documentosSubcomites';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'anio', 'ruta_documento', 'subcomite_id', 'tipo_documento', 'tipo_acta', 'publicado'];

    /**
     * Define la relación "uno a muchos" con los registros del modelo Subcomite.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcomite()
    {
        return $this->belongsTo(Subcomite::class, 'subcomite_id');
    }
}
