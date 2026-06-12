<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Modelo Evento.
 *
 * Representa un evento del calendario. Utiliza un mutator de Eloquent
 * para calcular y almacenar automáticamente componentes de la fecha.
 */
class Evento extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     * @var array<int, string>
     */
    protected $fillable = ['titulo', 'fecha_evento', 'dia', 'dia_semana', 'mes_anio', 'icono_evento'];

    /**
     * Mutator para el atributo 'fecha_evento'.
     *
     * Esta función es un "mutator" de Eloquent, lo que significa que se ejecuta
     * automáticamente cada vez que se intenta establecer el valor de 'fecha_evento'.
     *
     * Su propósito es tomar la fecha proporcionada, y a partir de ella, calcular
     * y rellenar automáticamente los campos 'dia', 'dia_semana' y 'mes_anio'
     * en el modelo antes de guardarlo en la base de datos.
     *
     * @param  string $value La fecha en un formato que Carbon pueda interpretar (ej. 'Y-m-d').
     * @return void
     */
    public function setFechaEventoAttribute($value)
    {
        $this->attributes['fecha_evento'] = $value;
        $date = Carbon::parse($value);
        // Calcula y asigna los valores derivados de la fecha.
        $this->attributes['dia'] = $date->day;
        $this->attributes['dia_semana'] = $date->locale('es')->isoFormat('dddd');
        $this->attributes['mes_anio'] = $date->locale('es')->isoFormat('MMMM YYYY');
    }
}
