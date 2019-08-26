<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;

use it\Misc;
use it\Origin;
use DB;

class OriginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
       $this->middleware('auth');
     }

    public function index()
    {
        $origins = DB::table('origins AS o')
            ->join('misc AS m', 'o.misc_id', '=', 'm.id')
            ->select('o.*', 'm.name AS misc_name', 'm.group AS misc_group')
            ->orderBy('o.name', 'asc')
            ->get();

        //$origins = Origin::all();
            
        return $origins;        
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
        $response = array();
        $response['msj'] = "";
        $response['success'] = false;

        try {
            
            $nombre_origen = ucwords(addslashes($request->input('nombre_origen')));
            $tipo_origen = ucwords(addslashes($request->input('tipo_origen')));

            if ($nombre_origen == '')
                throw new \Exception("El nombre de origen no puede estar vacio.");

            if (!is_numeric($tipo_origen))
                throw new \Exception("El tipo de origen no puede estar vacio.");

            $origin = new Origin();

            $origin->name = $nombre_origen;
            $origin->misc_id = $tipo_origen;
            $origin->save();

            $response['elements'] = $origin;
            $response['success'] = true;
            $response['msj'] = "Registro guardado con exito.";
            
        } catch (Exception $e) {
            $response['msj'] = $e->getMessage();
        }

        return $response;
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
