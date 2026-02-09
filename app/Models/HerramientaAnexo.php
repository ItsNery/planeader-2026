<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerramientaAnexo extends Model
{
    use HasFactory;

    protected $table = 'herramientas_planeacion_anexos';

    protected $fillable = [
        'herramienta_id',
        'titulo',
        'archivo',
        'orden'
    ];

    public function herramienta()
    {
        return $this->belongsTo(HerramientaPlaneacion::class, 'herramienta_id');
    }
}
