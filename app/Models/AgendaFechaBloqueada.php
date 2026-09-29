<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaFechaBloqueada extends Model
{
    use HasFactory;

    protected $table = 'agenda_fechas_bloqueadas';

    protected $fillable = [
        'fecha_evento',
        'motivo',
    ];

    protected $casts = [
        'fecha_evento' => 'date',
    ];
}
