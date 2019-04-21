<?php

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;


class Permisos extends Model
{

    //protected $hidden = ['pivot'];

    protected $fillable = ["id","descripcion","grupo","su","created_at","updated_at"];

    public $table = 'permisos';

    public function permisoRoles(){

      return $this->belongsToMany(Rol::class, 'permiso_rol', 'permiso_id', 'rol_id');
      
    }
    
    public function permisoUsuarios(){

      return $this->belongsToMany(Usuario::class, 'permiso_usuario', 'permiso_id', 'usuario_id');
      
    }
    
}
