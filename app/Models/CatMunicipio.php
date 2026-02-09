<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Modelo para la entidad CatMunicipio.
 * Representa a un catálogo de municipios del estado de Puebla, pero su peculiaridad es que se contiene aqui las micro y macro regiones establecidas en la administración 2024-2030, con tres municipios extras para soportar la división del municipio de Puebla en cuatro microrregiones.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 *
 * @property int $id El identificador único del banner.
 * @property string $nombre_municipio El nombre del municipio (VARCHAR, obligatorio).
 * @property int $id_macrorregion El identificador de la macrorregión a la que pertenece el municipio (INT, obligatorio).
 * @property string $nombre_macrorregion El nombre de la macrorregión a la que pertenece el municipio (VARCHAR, obligatorio).
 * @property int $id_microrregion El identificador de la microrregión a la que pertenece el municipio (INT, obligatorio).
 * @property string $nombre_microrregion El nombre de la microrregión a la que pertenece el municipio (VARCHAR, obligatorio).
 * @property string $nombre_region El nombre de la región a la que pertenecia el municipio en la administración 2019-2024 (VARCHAR, nulo).
 * @property float $latitud La latitud del municipio (FLOAT, obligatorio).
 * @property float $longitud La longitud del municipio (FLOAT, obligatorio).
 * @property Carbon|null $created_at La fecha y hora de creación.
 * @property Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class CatMunicipio extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_macrorregion',
        'nombre_macrorregion',
        'id_microrregion',
        'nombre_microrregion',
        'nombre_region',
        'nombre_municipio',
        'latitud',
        'longitud',
    ];

    /**
     * Define la relación "uno a muchos" con los registros del modelo RegistroCapacitacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrosCapacitacion()
    {
        return $this->hasMany(RegistroCapacitacion::class, 'municipio_id');
    }
}
