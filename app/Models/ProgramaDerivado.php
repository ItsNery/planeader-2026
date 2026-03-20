<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad ProgramaDerivado.
 * Representa un programa derivado de un plan estatal.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * @property string $nombre El nombre del programa derivado (VARCHAR, obligatorio).
 * @property string $ruta_documento La ruta del documento (VARCHAR, obligatorio).
 * @property string $portada La portada del documento (VARCHAR, obligatorio).
 * @property string $tipo_derivado El tipo de derivado (VARCHAR, obligatorio).
 * @property int $planestatal_id El identificador del plan estatal (Integer, obligatorio).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class ProgramaDerivado extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'ruta_documento', 'portada', 'tipo_derivado', 'planestatal_id', 'publicado'];

    /**
     * Define la relación "uno a muchos" con los registros del modelo PlanEstatal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planestatal()
    {
        return $this->belongsTo(PlanEstatal::class, 'planestatal_id');
    }
}
