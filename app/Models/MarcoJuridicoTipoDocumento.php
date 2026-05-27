<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcoJuridicoTipoDocumento extends Model
{
    use HasFactory;

    protected $table = 'marco_juridico_tipos_documento';

    protected $fillable = ['nombre', 'slug'];

    public function clasificaciones()
    {
        return $this->hasMany(MarcoJuridicoClasificacion::class, 'tipo_documento_id');
    }
}
