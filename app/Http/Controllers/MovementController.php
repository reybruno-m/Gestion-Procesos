<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;
use it\Movement;
use DB;
use Illuminate\Support\Facades\Config;


class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        # Valor del Estado Inicial.
        $state_initial = Config::get('constants.initial_states.Inicial');
        
        # Verifico si el existen estados abiertos.
        $status = Movement::where([
                                ['task_id', '=', $request->input('id')], 
                                ['state_id', '!=', $state_initial],
                                ['finalized', '==', null]
                            ])
                    ->orderBy('id', 'desc')
                    ->get();

        # Mensajes de respuesta.
        $messages = [ 'id.integer' => 'Se produjo un error mientras se procesaba la solicitud.' ];

        # Reglas de validación.
        $rules = [ 'id' => 'required|integer' ];
       
        # Validacion de los request
        $validator = \Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails() || sizeof($status) > 0) 
        {
            $validator->errors()->add('', 'La tarea se encuentra actualmente tomada.');

            return [ 'success' => false, 'errors'  => $validator->errors()->all() ];
        }

        # Finalizo el movimiento anterior.
        Movement::where([
                    ['finalized', '=', NULL], 
                    ['task_id', '=', $request->input('id')]
                ])
            ->update(['finalized' => date("Y-m-d H:i:s")]);
        
        # Valor del Estado Tomado.
        $state_taked = Config::get('constants.initial_states.Tomado');
       	
       	# Inserto Nuevo Movimiento.
		$movement = new Movement();
        $movement->task_id = addslashes($request->input('id'));
        $movement->user_id = auth()->user()->id;
        $movement->state_id = $state_taked;
        //$movement->description = $description;
        $movement->taken = date("Y-m-d H:i:s");
		$movement->save();

        return [
            'success' => true,
            'elements' => $movement,
        ];       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        switch ($request->accion) {
            
            case 'actualizar_movimiento':
                
                $movement = Movement::find($id);

                if ($movement->state_id != $request->input('state')) {
                    $movement->state_id = $request->input('state');
                }

                $movement->description = $request->input('description');
                $movement->save();

                $movement = Movement::with(
                                'user',   # Usuarios de cada Movimiento.
                                'state'   # Estado de cada Movimiento.
                            )
                        ->where('id', '=', $id)
                        ->first();
                
                return $movement;       

                break;
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


    /*
        Tomar una tarea especifica.
    */

    public function add(Request $request)
    {
        # Valor del Estado Inicial.
        $state_initial = Config::get('constants.initial_states.Inicial');
        
        # Verifico si el existen estados abiertos.
        $status = Movement::where([
                                ['task_id', '=', $request->input('id')], 
                                ['state_id', '!=', $state_initial],
                                ['finalized', '==', null]
                            ])
                    ->orderBy('id', 'desc')
                    ->get();

        # Mensajes de respuesta.
        $messages = [ 'id.integer' => 'Se produjo un error mientras se procesaba la solicitud.' ];

        # Reglas de validación.
        $rules = [ 'id' => 'required|integer' ];
       
        # Validacion de los request
        $validator = \Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails() || sizeof($status) > 0) 
        {
            $validator->errors()->add('', 'La tarea se encuentra actualmente tomada.');

            return [ 'success' => false, 'errors'  => $validator->errors()->all() ];
        }

        # Finalizo el movimiento anterior.
        Movement::where([
                    ['finalized', '=', NULL], 
                    ['task_id', '=', $request->input('id')]
                ])
            ->update(['finalized' => date("Y-m-d H:i:s")]);
        
        # Valor del Estado Tomado.
        $state_taked = Config::get('constants.initial_states.Tomado');
        
        # Inserto Nuevo Movimiento.
        $movement = new Movement();
        $movement->task_id = addslashes($request->input('id'));
        $movement->user_id = auth()->user()->id;
        $movement->state_id = $state_taked;
        $movement->taken = date("Y-m-d H:i:s");
        $movement->save();

        return [
            'success' => true,
            'elements' => $movement,
        ];       
    }
}
