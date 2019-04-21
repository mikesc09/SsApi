<?php

namespace App\Models\Transacciones;

use Illuminate\Database\Eloquent\Model;

class LugarComision extends Model
{
    protected $fillable = [
        'id',
        'comision_id',
        'sede',
        'fecha_inicio',
        'fecha_termino',
        'cuota_diaria',
        'total_dias',
        'es_nacional',
        'termino',
        'created_at'
    ];

    public $table = "lugares_comisiones";


    public function lugaresComisiones()
    {
    //si no se le llama a la clave foranea comisiones_id, habra que definir como se llama el campo para obtenerlo
        return $this->belongsTo(Comision::class);
    }
    // invocar si y solo si se requiere saber cuantas comisiones se realizaron a esos lugares
    // como segundo parametro se manda el id de la comision para obtener la relacion
    public function comisionLugares()
    {
        return $this->hasMany(Comision::class, 'id');
    }



}
