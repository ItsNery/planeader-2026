<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionCopladep extends Model
{
    use HasFactory;

    protected $table = 'sesiones_copladep';

    protected $fillable = [
        'clave', 'nombre', 'tipo', 'numero', 'anio', 'descripcion', 'estado',
        'registro_inicio', 'registro_fin', 'fecha_evento', 'lugar', 'enlace_virtual',
        'agenda', 'ruta_publica',
    ];

    protected $casts = [
        'registro_inicio' => 'datetime',
        'registro_fin' => 'datetime',
        'fecha_evento' => 'datetime',
        'agenda' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'clave';
    }

    public function invitados()
    {
        return $this->hasMany(InvitadoCopladep::class);
    }

    public function registros()
    {
        return $this->hasMany(RegistroCopladep::class);
    }
}
