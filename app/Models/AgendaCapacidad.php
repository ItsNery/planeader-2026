<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaCapacidad extends Model
{
    use HasFactory;

    protected $table = 'agenda_capacidades';

    protected $fillable = [
        'fecha_evento',
        'max_eventos',
        'horarios',
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'horarios' => 'array',
    ];
}
