<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad Municipio.
 * Representa un municipio, este catálogo se usa para el apartado de planes municipales de desarrollo. NO CONFUNDIR CON CAT_MUNICIPIO, donde se guardan tres municipios extras para el tema de la regionalización.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento.
 * @property string $nombre El nombre del municipio (VARCHAR, obligatorio).
 * @property int $region_id El identificador único de la región (VARCHAR, obligatorio).
 * @property string $sitio_web La dirección del sitio web del municipio (VARCHAR, nulo).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class Municipio extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'region_id', 'sitio_web'];

    /**
     * Define la relación "uno a muchos" con los registros del modelo Region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function planesMunicipales()
    {
        return $this->hasMany(PlanMunicipal::class, 'municipio_id');
    }
}
