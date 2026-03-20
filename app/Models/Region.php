<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad Region.
 * Representa a las regiones del estado de Puebla, para la administración 2019-2024. Para las regiones de la administración 2024-2030, veáse el modelo Cat_municipios.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * @property string $nombre El nombre de la región (String, obligatorio).
 * @property int|null $region_id El identificador de la región padre (Integer, nulo).
 * 
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class Region extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla donde se guardan los registros.
     *
     * @var string
     */
    protected $table = 'regiones';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'numero_region', 'longitud', 'latitud'];

    /**
     * Define la relación "uno a muchos" con los registros del modelo Municipio.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'region_id', 'id');
    }
}
