<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad ProgramaEstatal.
 * Representa un programa estatal de un gobierno, no derivado del plan estatal, pero en la práctica uso el campo periodo del Plan Estatal para relacionarlos.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * @property int $plan_estatal_id El identificador del plan estatal con la periodicidad al que pertenece el programa (Integer, obligatorio).
 * @property string $nombre El nombre del programa (String, obligatorio).
 * @property string $ruta_documento La ruta del documento del programa (String, obligatorio).
 * @property string $portada La ruta de la portada del programa (String, obligatorio).
 * @property bool $publicado Indica si el programa está publicado (Boolean, obligatorio).
 * @property bool $historico Indica si el programa es histórico (Boolean, nulo).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */

class ProgramaEstatal extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'ruta_documento', 'portada', 'publicado', 'planestatal_id', 'historico'];

    /**
     * Define la relación "uno a muchos" con los registros del modelo PlanEstatal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planEstatal()
    {
        return $this->belongsTo(PlanEstatal::class, 'planestatal_id');
    }
}
