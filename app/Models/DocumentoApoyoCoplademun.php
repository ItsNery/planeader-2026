<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoApoyoCoplademun extends Model
{
    use HasFactory;
    protected $table = 'documentos_apoyo_coplademun';

    protected $fillable = [
        'titulo',
        'ruta_documento',
        'imagen',
        'orden',
        'publicado'
    ];
}
