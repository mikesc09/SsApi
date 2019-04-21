<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacciones\Comision;
use App\Models\Transacciones\LugarComision;
// use App\Models\Transacciones\MotivoComision;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ComisionController extends Controller
{
    /**
     * Display a listing of the resource.Transacciones
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

                    $comisiones = Comision::with('lugaresComision')->get();
                    $lugares = LugarComision::with('comisionLugares')->get();
                    //$motivos_comision = MotivoComision::with('motivosComisiones')->get();


                    
                    
                    // $com = DB::table('lugares_comisiones')
                    // ->where("id_comision",">","0")
                    // ->join('comisiones', 'comisiones.id', '=', 'lugares_comisiones.id_comision')
                    // ->get();

                    return $comisiones;
                    // return $com;

        
        // $comisiones = Comision::all();

        // foreach ($comisiones as $comision) {
        //     return $comisiones;
        // }

        

        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $datos = Input::json()->all();       
        
        $datos = (object) $datos;
        
        $comision = new Comision;
        
        $comision->motivo_comision = $datos->motivo_comision;
        $comision->no_comision  = $datos->no_comision;
        $comision->no_memorandum  = $datos->no_memorandum;
        $comision->usuario_id  = $datos->usuario_id;
        $comision->es_vehiculo_oficial  = $datos->es_vehiculo_oficial;
        $comision->fecha  = $datos->fecha;  
        $comision->total  = $datos->total;
        $comision->tipo_comision  = $datos->tipo_comision;
        $comision->placas  = $datos->placas;
        $comision->modelo  = $datos->modelo;
        $comision->status_comision  = $datos->status_comision;
        $comision->total_peaje  = $datos->total_peaje;
        $comision->total_combustible  = $datos->total_combustible;
        $comision->total_fletes_mudanza  = $datos->total_fletes_mudanza;
        $comision->total_pasajes_nacionales  = $datos->total_pasajes_nacionales;
        $comision->total_viaticos_nacionales  = $datos->total_viaticos_nacionales;
        $comision->total_viaticos_extranjeros  = $datos->total_viaticos_extranjeros;
        $comision->total_pasajes_internacionales  = $datos->total_pasajes_internacionales;
        $comision->nombre_subdepartamento  = $datos->nombre_subdepartamento;  
        $comision->organo_responsable_id  = $datos->organo_responsable_id;
        $comision->plantilla_personal_id  = $datos->plantilla_personal_id;
        
        
        if($comision->save()){
            if(property_exists($datos, "lugares_comision")){
                $lugares = array_filter($datos->lugares_comision, function($v){return $v !== null;});
                foreach ($lugares as $key => $value) {
                    //validar que el valor no sea null
                    if($value != null){
                        //comprobar si el value es un array, si es convertirlo a object mas facil para manejar.
                        if(is_array($value))
                            $value = (object) $value;
                            
                            $lugar = new LugarComision;
                            $lugar->comision_id           = $comision->id;
                            $lugar->sede                  = $value->sede;
                            $lugar->fecha_inicio          = $value->fecha_inicio;
                            $lugar->fecha_termino         = $value->fecha_termino;
                            $lugar->cuota_diaria          = $value->cuota_diaria;
                            $lugar->total_dias            = $value->total_dias;
                            $lugar->es_nacional           = $value->es_nacional;
                            $lugar->periodo               = $value->periodo;
                            $lugar->termino               = $value->termino;
                            $lugar->save();
                    }
                }
            }

            return response()->json(['success' => 'La comision se ha agregado con exito'], 200);

        }



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Comision::find($id);


        if(!$data){
            return response()->json(['error' => 'No se encuentra la comision que esta buscando'], 404);
        }

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
