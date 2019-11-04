<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;
use it\Movement;
use DB;
use Illuminate\Support\Facades\Config;


class MovementController extends Controller
{

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $errors = [];

        $id = addslashes(trim($id));
        $observacion = addslashes(trim($request->input('observacion')));
        $state = addslashes(trim($request->input('state')));


        if (!is_numeric($id)) {
            $errors[] = "Ocurrio un error mientras se procesaba la solicitud.";
            return [ 'success' => false, 'errors'  => $errors ];
        }

        if (!is_numeric($id) || $id == 0) {
            $errors[] = "El estado seleccionado es incorrecto, debe indicar uno del listado.";
            return [ 'success' => false, 'errors'  => $errors ];
        }


        if (strlen($observacion) == 0 || $observacion == "" || $observacion == "undefined") {
            $errors[] = "La observacion no puede estar vacia.";
            return [ 'success' => false, 'errors'  => $errors ];
        }

        $movement = Movement::find($id);
        
        if ($movement->finalized != null) {
            $errors[] = "El movimiento ya se encuentra finalizado.";
            return [ 'success' => false, 'errors'  => $errors ];
        }

        if ($movement->user_id != auth()->user()->id) {
            $errors[] = "El movimiento solo puede ser finalizado por el mismo usuario que lo crea.";
            return [ 'success' => false, 'errors'  => $errors ];
        }

        $movement->description = $observacion;
        $movement->state_id = $state;
        # $movement->user_finalized = auth()->user()->id;
        $movement->finalized = date("Y-m-d H:i:s");
        $movement->save();


        $movement = Movement::with(
                        'user',           # Usuarios de cada Movimiento.
                        'state',          # Estado de cada Movimiento.
                        'comments',       # Comentarios de cada Movimiento.
                        'comments.user'   # Usuarios de los comentarios.
                    )
                ->where('id', '=', $id)
                ->first();

        return [
            'success' => true,
            'movement' => $movement,
        ];       

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
