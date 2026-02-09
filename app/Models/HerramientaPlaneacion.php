<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerramientaPlaneacion extends Model
{
    use HasFactory;

    protected $table = 'herramientas_planeacion';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'archivo',
        'orden',
        'publicado'
    ];

    public function anexos()
    {
        return $this->hasMany(HerramientaAnexo::class, 'herramienta_id')->orderBy('orden');
    }
}
