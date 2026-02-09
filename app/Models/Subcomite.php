<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PlanEstatal;

/**
 * Modelo para la entidad Subcomite.
 * Representa a un subcomité dentro de un plan estatal.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * @property int $plan_estatal_id El identificador del plan estatal al que pertenece el subcomité (Integer, obligatorio).
 * @property string $nombre El nombre del subcomité (VARCHAR, obligatorio).
 * @property string $tipo_subcomite El tipo de subcomité (VARCHAR, obligatorio).
 * @property string $objetivo El objetivo del subcomité (VARCHAR, obligatorio).
 * @property string $conformacion La conformación del subcomité (VARCHAR, obligatorio).
 * @property string $icono El icono del subcomité (VARCHAR, null).
 * @property string $slug El slug del subcomité (VARCHAR, null).
 * @property bool $publicado Indica si el subcomité está publicado (Boolean, obligatorio).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */

class Subcomite extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'tipo_subcomite', 'objetivo', 'conformacion', 'icono', 'planestatal_id', 'slug', 'publicado'];

    /**
     * Define la relación "uno a muchos" con los registros del modelo PlanEstatal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planestatal()
    {
        return $this->belongsTo(PlanEstatal::class);
    }
}
