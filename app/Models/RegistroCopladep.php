<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCopladep extends Model
{
    use HasFactory;

    protected $table = 'registro_copladeps';

    protected $fillable = [
        'nombre_completo',
        'sexo',
        'cargo',
        'municipio_id',
        'correo_electronico',
        'telefono_oficina',
        'telefono_celular',
        'firma',
        'tipo_asistente',
        'invitado_id',
        'sesion',
    ];

    public function catMunicipio()
    {
        return $this->belongsTo(CatMunicipio::class, 'municipio_id');
    }

    public function invitado()
    {
        return $this->belongsTo(InvitadoCopladep::class, 'invitado_id');
    }
}
