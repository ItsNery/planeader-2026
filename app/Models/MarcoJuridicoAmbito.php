<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcoJuridicoAmbito extends Model
{
    use HasFactory;

    protected $table = 'marco_juridico_ambitos';

    protected $fillable = ['nombre', 'slug', 'orden', 'portada'];

    public function clasificaciones()
    {
        return $this->hasMany(MarcoJuridicoClasificacion::class, 'ambito_id');
    }
}
