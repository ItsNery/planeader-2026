<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad DocumentoCapacitacion.
 * Representa a un catálogo de documentos de capacitación del Coplademun de la página de Capacitaciones municipales del sistema.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 *
 * @property int $id El identificador único del documento de la capacitacion.
 * @property int $capacitacion_id El identificador de la capacitación a la que pertenece el documento (INT, obligatorio).
 * @property string $nombre_display El nombre del documento que se mostrará al usuario (VARCHAR, obligatorio).
 * @property string $ruta_archivo La ruta del archivo del documento (VARCHAR, obligatorio).
 * @property string $dia_agrupador El día de agrupación del documento (VARCHAR, nulo).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización
 */
class DocumentoCapacitacion extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'capacitacion_id',
        'nombre_display',
        'ruta_archivo',
        'dia_agrupador'
    ];

    /**
     * Define la relación "uno a muchos" con los registros del modelo Capacitacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function capacitacion()
    {
        return $this->belongsTo(Capacitacion::class);
    }
}
