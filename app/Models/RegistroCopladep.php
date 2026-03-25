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
    ];

    public function catMunicipio()
    {
        return $this->belongsTo(CatMunicipio::class, 'municipio_id');
    }
}
