<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatDependenciaCopladep extends Model
{
    use HasFactory;

    protected $table = 'cat_dependencias_copladep';

    protected $fillable = ['nombre', 'siglas', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function invitados()
    {
        return $this->hasMany(InvitadoCopladep::class, 'dependencia_id');
    }
}
