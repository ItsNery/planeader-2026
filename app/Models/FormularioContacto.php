<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad FormularioContacto.
 * Representa una respuesta al formulario de contacto del sitio.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 * @property int $id El identificador único del documento.
 * @property string $nombre El nombre del usuario que envió el formulario (VARCHAR, obligatorio).
 * @property string $correo El correo electrónico del usuario que envió el formulario (VARCHAR, obligatorio).
 * @property string $telefono El número de teléfono del usuario que envió el formulario (VARCHAR, obligatorio).
 * @property string $asunto El asunto del formulario (VARCHAR, obligatorio).
 * @property string $mensaje El mensaje del formulario (VARCHAR, obligatorio).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class FormularioContacto extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla donde se guardan los registros.
     *
     * @var string
     */
    protected $table = 'formularioscontacto';
    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'correo', 'telefono', 'asunto', 'mensaje'];
}
