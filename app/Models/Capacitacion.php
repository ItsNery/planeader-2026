<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Modelo para la entidad Capacitacion.
 * Representa a una capacitación del Coplademun de la pagina de Capacitaciones municipales del sistema.
 *
 * @author Nery Pozos Moreno
 * @version 1.0.0 2025-06-18
 *
 * @property int $id El identificador único de la capacitación.
 * @property string $nombre El nombre del banner (VARCHAR, obligatorio).
 * @property string $imagen_programa La ruta de la imagen de la capacitación 'Flyer' (VARCHAR, obligatorio).
 * @property Carbon|null $created_at La fecha y hora de creación.
 * @property Carbon|null $updated_at La fecha y hora de la última actualización.
 */

class Capacitacion extends Model
{
    use HasFactory;
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'imagen_programa',
    ];

    /**
     * Define la relación "uno a muchos" con los registros del modelo DocumentoCapacitacion.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentos()
    {
        return $this->hasMany(DocumentoCapacitacion::class);
    }
}
