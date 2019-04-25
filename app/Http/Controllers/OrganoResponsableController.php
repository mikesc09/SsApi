<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganoResponsableController extends Controller
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
        //utilizamos un try catch
        try
        {
            // el metodo de almacenar el catalogo
            $inputs = Input::json()->all();
            $data = OrganoResponsable::create($inputs);

            return Response::json([ 'data' => $data ],200);
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
        //actualizando el catalogo de organos responsables
        $input = Input::json()->all();
        try
        {
            // transformamos el arreglo en un objeto
            if (is_array($input))
                $input = (object) $input;

            $organoresponsable = new OrganoResponsable;

            $or = $organoresponsable::find($id);

            $or->nombre  = $input->nombre;
            $or->responsable = $input->responsable;
            $or->puesto_oficial = $input->puesto_oficial;

            $organo = $or->save();

            return Response::json([ 'data' => $organo ], 200);
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
