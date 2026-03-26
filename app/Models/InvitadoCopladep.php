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
        'municipio_id',
    ];

       public function municipio()
    {
        return $this->belongsTo(CatMunicipio::class, 'municipio_id', 'id');
    }
}
