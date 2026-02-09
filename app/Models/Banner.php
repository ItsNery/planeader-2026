<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Modelo para la entidad Banner.
 * Representa a un banner de la pagina principal del sistema.
 *
 * @author Nery Pozos Moreno
 * @version 1.1.0 2025-06-18
 *
 * @property int $id El identificador único del banner.
 * @property string $nombre El nombre del banner (VARCHAR, obligatorio).
 * @property string $imagen La ruta de la imagen del banner (VARCHAR, obligatorio).
 * @property string $descripcion La descripción del banner (TEXT, obligatorio).
 * @property string|null $enlace La URL a la que redirige el banner (puede ser nulo).
 * @property string $estado El estado del banner. Valores posibles: 'activo', 'inactivo', 'pendiente (ENUM, obligatorio).
 * @property string $seccion La sección donde se muestra el banner. Valores posibles: 'Inicio', 'COPLADEP', 'Programas Derivados', 'Plan Estatal' (estos útimos tres ya está en desuso por el actual diseño, pero pueden volverse a usar en ediciones posteriores) (ENUM, obligatorio).
 * @property int|null $orden El orden de visualización del banner (puede ser nulo).
 * @property Carbon|null $created_at La fecha y hora de creación.
 * @property Carbon|null $updated_at La fecha y hora de la última actualización.
 */

class Banner extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'imagen', 'descripcion', 'enlace', 'estado', 'seccion', 'orden'];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Esto asegura la integridad de los datos.
     *
     * @var array<string, string>
     */
    
    protected $casts = [
        'orden' => 'integer', // Asegura que 'orden' siempre sea un entero.
    ];
}
