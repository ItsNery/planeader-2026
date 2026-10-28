<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitadoCopladep extends Model
{
    protected $table = 'invitado_copladeps';

    protected $fillable = [
        'nombre_completo',
        'sexo',
        'cargo',
        'dependencia',
        'dependencia_id',
        'municipio_id',
        'check_in_express',
        'sesion',
        'sesion_copladep_id',
        'modalidad',
    ];
    
    protected $casts = [
        'check_in_express' => 'boolean',
    ];

    public function municipio()
    {
        return $this->belongsTo(CatMunicipio::class, 'municipio_id', 'id');
    }
    public function registro()
    {
        return $this->hasOne(RegistroCopladep::class, 'invitado_id', 'id');
    }

    public function sesionCopladep()
    {
        return $this->belongsTo(SesionCopladep::class);
    }

    public function dependenciaCopladep()
    {
        return $this->belongsTo(CatDependenciaCopladep::class, 'dependencia_id');
    }
}
