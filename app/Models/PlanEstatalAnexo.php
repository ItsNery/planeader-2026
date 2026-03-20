<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanEstatalAnexo extends Model
{
    use HasFactory;

    protected $table = 'plan_estatal_anexos';

    protected $fillable = [
        'plan_estatal_id',
        'titulo',
        'es_enlace',
        'ruta_documento',
        'imagen',
        'orden',
        'publicado'
    ];

    public function planEstatal()
    {
        return $this->belongsTo(PlanEstatal::class, 'plan_estatal_id');
    }
}
