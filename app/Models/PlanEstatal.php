<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad PlanEstatal.
 * Representa un documento de plan estatal, que se muestra en la página del mismo nombre en el sitio.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * @property string $nombre El nombre del documento (VARCHAR, obligatorio).
 * @property string $periodo El período al que pertenece el documento (VARCHAR, obligatorio).
 * @property string $ruta_documento La ruta del documento (VARCHAR, obligatorio).
 * @property string $portada La ruta de la portada del documento (VARCHAR, obligatorio).
 * @property string $gobernador El nombre del gobernador asociado al documento (VARCHAR, obligatorio).
 * @property bool $publicado Indica si el documento está publicado (Boolean, obligatorio).
 * @property int $orden El orden del documento en la lista (Integer, obligatorio).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class PlanEstatal extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'periodo', 'ruta_documento', 'portada', 'gobernador', 'publicado', 'orden'];

    /**
     * Define la relación "uno a muchos" con los registros del modelo ProgramaEstatal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programasEstatales()
    {
        return $this->hasMany(ProgramaEstatal::class);
    }

    /**
     * Define la relación "uno a muchos" con los anexos del plan estatal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function anexos()
    {
        return $this->hasMany(PlanEstatalAnexo::class, 'plan_estatal_id')->orderBy('orden');
    }

    /**
     * Define la relación "uno a muchos" con los documentos de insumos PED.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentoInsumoPeds()
    {
        return $this->hasMany(DocumentoInsumoPed::class, 'plan_estatal_id');
    }
}
