<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad PlamMunicipal.
 * Representa un documento de plan municipal de desarrollo en la base de datos.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * @property string $nombre El nombre del documento (String, obligatorio).
 * @property string $periodo El periodo del plan (String, obligatorio).
 * @property string $ruta_documento La ruta del documento (String, obligatorio).
 * @property int $municipio_id El identificador del municipio al que pertenece el plan (Integer, obligatorio).
 * @property string $tipo El tipo de plan (String, nulo).
 * @property bool $publicado Indica si el plan está publicado (Boolean, nulo).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class PlanMunicipal extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla donde se guardan los registros.
     *
     * @var string
     */
    protected $table = 'planes_municipales';
    
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'periodo', 'ruta_documento', 'municipio_id', 'tipo', 'publicado'];


    /**
     * Define la relación "uno a muchos" con los registros del modelo Municipio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }
}
