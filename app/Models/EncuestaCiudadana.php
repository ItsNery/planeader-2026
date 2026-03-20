<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad EncuestaCiudadana.
 * Representa una respuesta a la encuesta ciudadana para la Elaboración del PED 2024-2030.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento.
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class EncuestaCiudadana extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        '1_1',
        '1_2',
        '1_3',
        '2_1',
        '2_2',
        '3_1',
        '3_2',
        '4_1',
        '4_2',
        '5_1',
        '5_2',
        '6_1',
        '6_2',
        '6_3',
        '7_1',
        '7_2',
        '8_1',
        '8_2',
        '9_1',
        '9_2',
        '9_3',
        '9_4',
        '9_5',
        '9_6',
        '9_6_1',
        '9_7',
        '9_7_1',
        '9_8',
        '9_9',
    ];
}
