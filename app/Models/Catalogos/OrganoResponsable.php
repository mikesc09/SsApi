<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $responsable
 * @property string $puesto_oficial
 * @property string $created_at
 * @property string $updated_at
 * @property Comisione[] $comisiones
 * @property Subdepartamento[] $subdepartamentos
 */
class OrganoResponsable extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'organos_responsables';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'responsable', 'puesto_oficial', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comisiones()
    {
        return $this->hasMany('App\Models\Transacciones\Comision', 'organo_responsable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subdepartamentos()
    {
        return $this->hasMany('App\Models\Catalogos\Subdepartamento', 'organo_responsable_id');
    }
}
