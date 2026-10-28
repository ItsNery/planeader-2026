<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitadoCopladep extends Model
{
    protected $table = 'invitado_copladeps';

    protected $fillable = [
        'nombre_completo',
        'sexo',
        'cargo',
        'dependencia',
        'dependencia_id',
        'municipio_id',
        'check_in_express',
        'sesion',
        'sesion_copladep_id',
        'modalidad',
    ];
    
    protected $casts = [
        'check_in_express' => 'boolean',
    ];

    public function municipio()
    {
        return $this->belongsTo(CatMunicipio::class, 'municipio_id', 'id');
    }
    public function registro()
    {
        return $this->hasOne(RegistroCopladep::class, 'invitado_id', 'id');
    }

    public function registros()
    {
        return $this->hasMany(RegistroCopladep::class, 'invitado_id');
    }

    public function ingresosQr()
    {
        return $this->registros()->whereNotNull('check_in_at');
    }

    public function presente(): bool
    {
        return $this->check_in_express || $this->ingresosQr->isNotEmpty();
    }

    public function estadoAsistencia($fechaEvento): string
    {
        if (! $this->presente()) return 'Falta';

        // El QR conserva la hora real; updated_at es la referencia disponible para el pase manual.
        $fechaIngreso = $this->ingresosQr->min('check_in_at');
        if ($this->check_in_express && $this->updated_at && (! $fechaIngreso || $this->updated_at->lessThan($fechaIngreso))) {
            $fechaIngreso = $this->updated_at;
        }
        return $fechaEvento && $fechaIngreso && $fechaIngreso->greaterThan($fechaEvento)
            ? 'Asistencia con retardo' : 'Presente';
    }

    public function sesionCopladep()
    {
        return $this->belongsTo(SesionCopladep::class);
    }

    public function dependenciaCopladep()
    {
        return $this->belongsTo(CatDependenciaCopladep::class, 'dependencia_id');
    }
}
