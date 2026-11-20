<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoReferenciaSesion extends Model
{
    protected $table = 'documentos_referencia_sesion';
    protected $fillable = ['nombre', 'ruta'];
}
