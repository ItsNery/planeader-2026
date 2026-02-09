<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoMetodologico extends Model
{
    use HasFactory;
    protected $table = 'documentos_metodologicos';

    protected $fillable = [
        'titulo',
        'ruta_documento',
        'imagen',
        'orden',
        'publicado'
    ];
}
