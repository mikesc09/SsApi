<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubDepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //guardar registros de la petición
        try
        {
            $datos = Input::json()->all();
            if (is_array(datos))
                $data = (object) $datos;

            $subdepartamento = new Subdepartamento;

            $subdepartamento->organo_responsable_id = $data->organo_responsable_id;
            $subdepartamento->nombre_departamento   = $data->nombre_departamento;

            $datas = $subdepartamento::create($data);

            return Response::json([ 'data' => $datas ], 200);
        }
        catch(Exception $e)
        {
            return Response::json(['error' => $e->getMessage(), 'code' => 409], 409);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //actualizar catalogo
        try
        {
            $input = Input::json()->all();
            if(is_array($input))
                $input = (object) $input;

            $subdepto = new Subdepartamento;

            $data = $subdepto::find($id);
            $data->organo_responsable_id    = $input->organo_responsable_id;
            $data->nombre_departamento      = $input->nombre_departamento;

            $sdepto = $data->save();
            return Response::json([ 'data' => $sdepto ], 200);
        }
        catch(Exception $e)
        {
            return Response::json(['error' => $e->getMessage(), 'code' => 409], 409);
        }
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
