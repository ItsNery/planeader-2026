<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad Problematia.
 * Representa una respuesta a la encuesta ciudadana en la parte de problemáticas.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * Desconozco todas las demás propiedades, ya que no se especificaron en el código original.
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */

class Problematica extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'genero',
        'edad',
        'escolaridad',
        'ocupacion',
        'estado_civil',
        'municipio',
        'lengua_indigena',
        'lengua_indigena_si',
        'discapacidad',
        'discapacidad_si',
        'tematica',
        'problematica',
        'solucion',
    ];
}
