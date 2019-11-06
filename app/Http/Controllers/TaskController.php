<?php
namespace it\Http\Controllers;

use Illuminate\Http\Request;
use it\Misc;
use it\User;
use it\Origin;
use it\Task;
use it\Movement;
use DB;
use Illuminate\Support\Facades\Config;


class TaskController extends Controller
{
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

        //$tasks = Task::with('movements', 'misc', 'user', 'origin')->get();
        $tasks = Task::with(
                        'movements',                # Movimientos de la tarea.
                        'user',                     # Usuario que crea la tarea.
                        'origin',                   # Origen de la tarea.
                        'destinity',                # Destino de la tarea.
                        'misc',                     # Prioridad de la tarea.
                        'movements.user',           # Usuarios de cada Movimiento.
                        'movements.state',          # Estado de cada Movimiento.
                        'movements.comments',       # Comentarios de cada Movimiento.
                        'movements.comments.user'   # Usuarios de los comentarios.
                    )->get();
        $res = [];
        
        $res['tasks'] = $tasks;
        $res['user_id'] = auth()->user()->id;
        $res['origin_id'] = auth()->user()->origin_id;

        return $res;
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
        

        // Mensajes de respuesta.
        $messages = [
            'origin_id.required' => 'Debe seleccionar un origen del listado.',
            'origin_id.integer' => 'El origen indicado no es valido.',
            'destinity_id.required' => 'Debe seleccionar destino del listado.',
            'destinity_id.integer' => 'El destino indicado no es valido.',
            'description.min' =>'La descripcion debe contener al menos 10 caracteres.',
            'misc_id.required' => 'Debe seleccionar una prioridad del listado.',            
            'misc_id.integer' => 'La prioridad indicada no es valida.',
        ];

        // Reglas de validación.
        $rules = [
                'origin_id'     => 'required|integer',
                'misc_id'       => 'required|integer',
                'destinity_id'   => 'required|integer',
                'description'   => 'required|min:10'
            ];
        
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors'  => $validator->errors()->all()
            ];
        } 


        # Inserto la Tarea.

        $task = new Task();
        
        $task->description = addslashes($request->input('description')); 
        $task->misc_id = $request->input('misc_id');
        $task->user_id = auth()->user()->id;
        $task->origin_id = $request->input('origin_id');
        $task->destinity_id = $request->input('destinity_id');
        $task->state = 1;
        $task->created_at = date('Y-m-d H:i:s');
        $task->updated_at = date('Y-m-d H:i:s');
        
        $task->save();

        # Valor del Estado Inicial.
        $state_initial = Config::get('constants.initial_states.Inicial');


        # Inserto el primer Movimiento.

        $movement = new Movement();
        $movement->task_id = $task->id;
        $movement->user_id = auth()->user()->id;
        $movement->state_id = $state_initial;
        $movement->taken = date('Y-m-d H:i:s');

        $movement->save();
        
        $elements = Task::with(
                        'movements',                # Movimientos de la tarea.
                        'user',                     # Usuario que crea la tarea.
                        'origin',                   # Origen de la tarea.
                        'destinity',                # Destino de la tarea.
                        'misc',                     # Prioridad de la tarea.
                        'movements.user',           # Usuarios de cada Movimiento.
                        'movements.state',          # Estado de cada Movimiento.
                        'movements.comments',       # Comentarios de cada Movimiento.
                        'movements.comments.user'   # Usuarios de los comentarios.
                    )->orderBy('created_at', 'desc')->first();

        return [
            'success' => true,
            'elements' => $elements,
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
        if (is_numeric($id)) {

            $task = Task::with(
                            'movements',                # Movimientos de la tarea.
                            'user',                     # Usuario que crea la tarea.
                            'origin',                   # Origen de la tarea.
                            'destinity',                # Destino de la tarea.
                            'misc',                     # Prioridad de la tarea.
                            'movements.user',           # Usuarios de cada Movimiento.
                            'movements.state',          # Estado de cada Movimiento.
                            'movements.comments',       # Comentarios de cada Movimiento.
                            'movements.comments.user'   # Usuarios de los comentarios.
                        )
                    ->where('id', '=', $id)
                    ->first();
            # dd($task);
            return $task;
        }
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $errors = [];

        if (!is_numeric($id)) {
            $errors[] = "Ocurrio un error mientras se procesaba la solicitud.";
            return [ 'success' => false, 'errors'  => $errors ];
        }
        
        # Obtengo los movimientos de la tarea
        $movements_task = Movement::where('task_id', '=', $id)->get();
        $cantidad_movimientos = sizeof($movements_task);

        # Valor del Estado Finalizado.
        $state_finalized = Config::get('constants.initial_states.Finalizado');

        # Estado del ultimo movimiento.
        $state_last_movement = $movements_task[$cantidad_movimientos - 1]->state_id;

        if ($state_finalized != $state_last_movement) {

            # LA TAREA NO ESTA FINALIZADA Y PUEDE SER ELIMINADA.

            if ($cantidad_movimientos == 1 ) {

                # EL USUARIO QUE LA CREA O UN ADMINISTRADOR LA PUEDEN BORRAR.
                Movement::where('task_id', '=', $id)->delete();
                Task::where('id', '=', $id)->delete();

                return [ 'success' => true, 'msj'  => "La tarea fue eliminada satisfactoriamente." ];

            }else{

                # SOLO EL ADMINISTRADOR PUEDE BORRARLA.
                $admin = false;
                $admin = $request->user()->hasAnyRole('administrator');

                if ($admin) {
                    # BORRA REGISTROS.
                    
                    Movement::where('task_id', '=', $id)->delete();
                    Task::where('id', '=', $id)->delete();

                    return [ 'success' => true, 'msj'  => "La tarea fue eliminada satisfactoriamente." ];

                }else{
                    # USUARIO NO ADMIN.
                    $errors[] = "La tarea solo puede ser eliminada por un administrador.";
                }

                
                if ($validator->fails()){
                    return [ 'success' => false, 'errors'  => $errors ];
                }
            }
        
        }else{
            
            # NO SE PUEDEN ELIMINAR LAS TAREAS FINALIZADAS.
            $errors[] = "La tarea ya fue finalizada y no puede ser eliminada.";
            
            return [ 'success' => false, 'errors'  => $errors ];
        }

    }
}
