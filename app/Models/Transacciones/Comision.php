<?php

namespace App\Models\Transacciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Comision extends Model
{

    protected $fillable = [
        'id',
        'motivo_comision',
        'no_comision',
        'no_memorandum',
        'usuario_id',
        'es_vehiculo_oficial',
        "fecha",
        "total",
        'tipo_comision',
        'placas',
        'modelo',
        'status_comision',
        'total_peaje',
        'total_combustible',
        'total_fletes_mudanza',
        'total_pasajes_nacionales',
        'total_viaticos_nacionales',
        'total_viaticos_extranjeros',
        'total_pasajes_internacionales',
        'nombre_subdepartamento',
        'organo_responsable_id',
        'plantilla_personal_id',
        'created_at'
    ];

    public $table = "comisiones";

    public function lugaresComision()
    {
        return $this->hasMany(LugarComision::class);
    }

//     public function motivosComision()
//     {
//         return $this->hasMany(MotivoComision::class);
//     }

//     public function formatosComprobacionComision()
//     {
//         return $this->hasMany(FormatosComprobacionComision::class);
//     }
// //checar si solo uno o tendra muchas claves la comision
//     public function clavePresupuestalComision()
//     {
//         return $this->hasMany(ClavePresupuestalComision::class);
//     }

}
