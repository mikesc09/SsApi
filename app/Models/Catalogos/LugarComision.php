<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $comision_id
 * @property string $sede
 * @property string $fecha_inicio
 * @property string $fecha_termino
 * @property float $cuota_diaria
 * @property int $total_dias
 * @property mixed $es_nacional
 * @property int $periodo
 * @property string $termino
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Comision $comision
 */
class LugarComision extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lugares_comisiones';

    /**
     * @var array
     */
    protected $fillable = ['comision_id', 'sede', 'fecha_inicio', 'fecha_termino', 'cuota_diaria', 'total_dias', 'es_nacional', 'periodo', 'termino', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comision()
    {
        return $this->belongsTo('App\Models\Transacciones\Comision', 'comision_id');
    }
}
