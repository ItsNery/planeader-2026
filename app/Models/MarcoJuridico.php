<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad MarcoJuridico.
 * Representa un documento del marco jurídico, que se muestra en la página del mismo nombre en el sitio.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento.
 * @property string $nombre El nombre del documento (VARCHAR, obligatorio).
 * @property string $ruta_documento La ruta del documento (VARCHAR, obligatorio).
 * @property string $portada La ruta de la portada del documento (VARCHAR, obligatorio).
 * @property int $orden El orden del documento en la lista (Integer, nulo).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class MarcoJuridico extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla donde se guardan los registros.
     *
     * @var string
     */
    protected $table = 'marcojuridico';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'ruta_documento', 'portada', 'orden'];
}
