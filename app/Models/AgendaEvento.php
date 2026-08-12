<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AgendaEvento extends Model
{
    use HasFactory;

    protected $table = 'agenda_eventos';

    protected $fillable = [
        'folio',
        'tipo_evento',
        'subcomite_id',
        'tematica',
        'institucion_organizadora',
        'fecha_evento',
        'hora_inicio',
        'hora_fin',
        'modalidad',
        'liga_videoconferencia',
        'ubicacion',
        'solicitante_nombre',
        'solicitante_cargo',
        'solicitante_email',
        'solicitante_telefono',
        'correos_invitados',
        'estado',
        'observaciones_admin',
        'comentarios',
        'publicado',
        'confirmado_at',
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'publicado' => 'boolean',
        'confirmado_at' => 'datetime',
    ];

    public function subcomite()
    {
        return $this->belongsTo(Subcomite::class);
    }

    public function scopeActivos($query)
    {
        return $query->whereIn('estado', ['pendiente', 'confirmado']);
    }

    public function estaActivo(): bool
    {
        return in_array($this->estado, ['pendiente', 'confirmado'], true);
    }

    public static function fechaEsNoLaborable(string $fecha): bool
    {
        $date = Carbon::parse($fecha);

        return $date->isWeekend() || in_array($date->format('Y-m-d'), self::diasFestivos($date->year), true);
    }

    public static function diasFestivos(int $year): array
    {
        $primerLunesFebrero = Carbon::create($year, 2, 1);
        while ($primerLunesFebrero->dayOfWeek !== Carbon::MONDAY) {
            $primerLunesFebrero->addDay();
        }

        $tercerLunesMarzo = Carbon::create($year, 3, 1);
        while ($tercerLunesMarzo->dayOfWeek !== Carbon::MONDAY) {
            $tercerLunesMarzo->addDay();
        }
        $tercerLunesMarzo->addWeeks(2);

        $tercerLunesNoviembre = Carbon::create($year, 11, 1);
        while ($tercerLunesNoviembre->dayOfWeek !== Carbon::MONDAY) {
            $tercerLunesNoviembre->addDay();
        }
        $tercerLunesNoviembre->addWeeks(2);

        return array_values(array_unique(array_merge([
            Carbon::create($year, 1, 1)->format('Y-m-d'),
            $primerLunesFebrero->format('Y-m-d'),
            $tercerLunesMarzo->format('Y-m-d'),
            Carbon::create($year, 5, 1)->format('Y-m-d'),
            Carbon::create($year, 9, 16)->format('Y-m-d'),
            $tercerLunesNoviembre->format('Y-m-d'),
        ], config('agenda.festivos_adicionales', []))));
    }

    public function tituloPublico(): string
    {
        if ($this->tipo_evento === 'sesion') {
            return 'Sesión de ' . ($this->subcomite?->nombre ?? 'Subcomité');
        }

        return 'Mesa Técnica de Trabajo';
    }

    public function descripcionTipo(): string
    {
        return $this->tipo_evento === 'sesion' ? 'Sesión de subcomité' : 'Mesa técnica de trabajo';
    }

    public function horaInicioFormateada(): string
    {
        return substr((string) $this->hora_inicio, 0, 5);
    }
}
