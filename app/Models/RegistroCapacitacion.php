<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Modelo para la entidad RegistroCapacitacion.
 * Representa a un registro de persona a alguna de las capacitaciones municipales.
 *
 * @author Nery Pozos Moreno
 * @version 1.0.0 2025-06-18
 *
 * @property int $id El identificador único de la capacitación.
 * @property string $nombreCompleto El nombre completo de la persona que se registró (Varchar, obligatorio).
 * @property string $correo El correo electrónico de la persona que se registró (Varchar, obligatorio).
 * @property string $sexo El sexo de la persona que se registró (Varchar, obligatorio).
 * @property string $cargo El cargo de la persona que se registró (Varchar, obligatorio).
 * @property int $municipio_id El identificador del municipio al que pertenece la persona (INT, nulo).
 * @property string $telefono_oficina El número de teléfono de oficina de la persona que se registró (Varchar, nulo).
 * @property string $telefono_celular El número de teléfono celular de la persona que se registró (Varchar, nulo).
 * @property string $correo_electronico El correo electrónico de la persona que se registró (Varchar, obligatorio).
 * @property Carbon|null $created_at La fecha y hora de creación.
 * @property Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class RegistroCapacitacion extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla donde se guardan los registros.
     *
     * @var string
     */
    protected $table = 'registro_capacitacions';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_completo',
        'sexo',
        'cargo',
        'municipio_id',
        'correo_electronico',
        'telefono_oficina',
        'telefono_celular',
    ];
    // Relación: Un registro de capacitación pertenece a un municipio
    public function catMunicipio() // Nombre de la relación, singular
    {
        return $this->belongsTo(CatMunicipio::class, 'municipio_id', 'id');
    }
}
