<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo para la entidad DocumentoInsumoPed.
 * Representa documentos de insumos relacionados con el Plan Estatal de Desarrollo,
 * incluyendo Árboles de problemas y Fichas de indicadores.
 *
 * @author Nery Pozos Moreno
 * @version 1.0.0
 * @property int $id El identificador único del documento (Integer, obligatorio).
 * @property string $titulo El título del documento (VARCHAR, obligatorio).
 * @property string $tipo El tipo de documento: 'arbol-problemas' o 'fichas-indicadores' (VARCHAR, obligatorio).
 * @property string $ruta_documento La ruta del documento (VARCHAR, obligatorio).
 * @property string $formato El formato del documento: 'pdf' o 'excel' (VARCHAR, obligatorio).
 * @property bool $publicado Indica si el documento está publicado (Boolean, obligatorio).
 * @property \Illuminate\Support\Carbon|null $created_at La fecha y hora de creación.
 * @property \Illuminate\Support\Carbon|null $updated_at La fecha y hora de la última actualización.
 */
class DocumentoInsumoPed extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['plan_estatal_id', 'titulo', 'tipo', 'ruta_documento', 'formato', 'publicado'];

    /**
     * Define la relación "muchos a uno" con el modelo PlanEstatal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planEstatal()
    {
        return $this->belongsTo(PlanEstatal::class, 'plan_estatal_id');
    }

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'publicado' => 'boolean',
    ];
}
