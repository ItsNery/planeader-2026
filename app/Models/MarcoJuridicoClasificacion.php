<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcoJuridicoClasificacion extends Model
{
    use HasFactory;

    protected $table = 'marco_juridico_clasificaciones';

    protected $fillable = ['ambito_id', 'tipo_documento_id'];

    public function ambito()
    {
        return $this->belongsTo(MarcoJuridicoAmbito::class, 'ambito_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(MarcoJuridicoTipoDocumento::class, 'tipo_documento_id');
    }

    public function documentos()
    {
        return $this->hasMany(MarcoJuridico::class, 'marco_juridico_clasificacion_id');
    }
}
