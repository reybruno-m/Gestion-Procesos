<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;

use it\Misc;
use it\Origin;
use DB;

class OriginController extends Controller
{
   // public $response = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

    }

    public function index()
    {
        $origins = DB::table('origins AS o')
            ->join('misc AS m', 'o.misc_id', '=', 'm.id')
            ->select(
                'o.*', 
                'm.name AS misc_name', 
                'm.group AS misc_group'
            )
            ->orderBy('o.name', 'asc')
            //->where('state', '=', 'active')
            ->get();

        return $origins;        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = [];
        
        $usado = DB::table('origins')
            ->where('name', '=', ucwords(strtolower($request->input('name'))))
            ->count();

        $messages = [
            'name.required' => 'El nombre no puede estar vacio.',
            'name.max' => 'El nombre no puede superar los 100 caracteres.',
            'misc_id.required' => 'El tipo de origen no puede estar vacio.',
            'state.integer' => 'El estado inicial no puede estar vacio.',
        ];

        $rules = [
            'name'     => 'required|string|max:100|',
            'misc_id'  => 'required|integer',
            'state'    => 'required|string', 
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails() || $usado > 0) {

            if ($usado > 0) {
                $name = ucwords(strtolower($request->input('name')));
                $validator->errors()->add('', 'El origen ' . $name . " Ya se encuentra cargado.");
            }

            $response['success'] = false;
            $response['errors'] = $validator->errors()->all();
            return $response;

        }else{

            $origin = new Origin();
            
            $origin->name = ucwords(strtolower(trim($request->input('name'))));
            $origin->misc_id = $request->input('misc_id');
            $origin->state = $request->input('state');
            
            $origin->save();

            $tipo_origen = Misc::find($request->input('misc_id'));
            $origin->misc_name = $tipo_origen->name;

            $response['success'] = true;
            $response['msj'] = 'Registro guardado con exito.';
            $response['elements'] = $origin;

            return $response; 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $response = [];

        $messages = [
            'id.required' => 'Error al procesar la solicitud.',
            'name.required' => 'Debe indicar un nombre valido.',
            'name.max' => 'El nombre no puede superar los 100 caracteres.',
            'misc_id.required' => 'Debe seleccionar un tipo del listado.',
            'state.integer' => 'Debe seleccionar un estado inicial.',
        ];

        $rules = [
            'id'        => 'required|integer',
            'name'      => 'required|string|max:100',
            'misc_id'   => 'required|integer',
            'state'     => 'required|string',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['errors'] = $validator->errors()->all();
            return $response;
        }

        $origin = Origin::find($request->input('id'));

        $origin->name = ucwords(strtolower($request->input('name')));
        $origin->misc_id = $request->input('misc_id');
        $origin->state = $request->input('state');

        $response['success'] = true;
        $response['msj'] = "Registro actualizado con exito.";

        $origin->save();
        $response['element'] = $origin;

        return $response;       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [];
        
        if (!is_numeric($id)) {
            
            $response['success'] = false;
            $response['errors'] = array("El registro no puede ser eliminado.");
            return $response; 
        }

        $cantidad = DB::table('tasks')
            ->where('origin_id', '=', $id)
            ->count();

        if ($cantidad > 0) {

            $response['success'] = false;
            $response['errors'] = array("El Origen que intenta eliminar se encuentra actualmente en uso en " . $cantidad . " solicitudes.");

            return $response; 
        }  

        $origin = Origin::find($id);
        $origin->delete();

        $response['success'] = true;
        $response['msj'] = "Origen eliminado con exito.";
        
        return $response; 
    }

    /*
        Modifica el estado actual de un origen.
    */

    public function changeState($id)
    {
        $response = [];
        
        if (!is_numeric($id)) {
            
            $response['success'] = false;
            $response['errors'] = array("El registro no puede ser eliminado.");
            return $response; 
        }

        $origin = Origin::findOrFail($id);

        if ($origin->state == 'active') {

            $origin->state = 'inactive';
            $response['msj'] = "Registro Desactivado con exito.";
        
        }else{
        
            $origin->state = 'active';
            $response['msj'] = "Registro Activado con exito.";
        
        }

        $origin->save();
        
        $response['success'] = true;
        $response['element'] = $origin;
        
        return $response;       
    }

}
