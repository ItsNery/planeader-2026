<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad Proyecto.
 * Representa un resultado de la encuesta ciudadana para la elaboración del Plan Estatal de Desarrollo (PED) 2024-2030 en el apartado de proyectos.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * Desconozco las demás propiedades, ya que no se especificaron en el código original.
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */

class Proyecto extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'responsable',
        'organizacion',
        'telefono',
        'correo',
        'nombre_proyecto',
        'antecedentes',
    ];
}
