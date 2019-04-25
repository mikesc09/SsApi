<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlantillaPersonalController extends Controller
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
        // almacenamiento
        try
        {
            //el metodo de almacenar el catalogo
            // $input = $request->all();
            $input = Input::json()->all();
            $data = new PlantillaPersonal;

            $pp = $data::create($input);

            return Response::json([ 'data' => $pp ], 200);
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
        // actualizar la petición
        $input = Input::json()->all();
        try
        {
            if(is_array($input))
                $input = (object) $input;

            $personaldata = PlantillaPersonal::find($id);

            $personaldata->nombre       = $input->nombre;
            $personaldata->apellido_paterno = $input->apellido_paterno;
            $personaldata->apellido_materno = $input->apellido_materno;
            $personaldata->categiria        = $input->categiria;
            $personaldata->rfc              = $input->rfc;

            $personal = $personaldata->save();

            return Response::json([ 'data' => $personal ], 200);
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
