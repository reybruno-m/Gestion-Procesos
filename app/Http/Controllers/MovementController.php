<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;
use it\Movement;
use DB;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movements = DB::table('movements AS m')
            ->join('requests AS r', 'm.request_id', '=', 'r.id')
            ->join('users AS u', 'm.user_id', '=', 'u.id')
            ->join('states AS s', 'm.state_id', '=', 's.id')
            ->select(
                'm.*', 
                'r.id AS request_id', 
                'r.description AS request_description', 
                'r.misc_id AS request_misc_id', 
                'r.created_at AS request_created_at', 
                'r.updated_at AS request_updated_at', 
                'u.last_name', 
                'u.first_name', 
                'u.email', 
                's.name'
            )
            ->get();

        return $movements;        
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

        $status = Movement::where('request_id', '=', $request->input('id') )
                    ->orderBy('id', 'desc')
                    ->first();

        // Mensajes de respuesta.
        $messages = [
            'id.integer' => 'Se produjo un error mientras se procesaba la solicitud.',
        ];

        // Reglas de validación.
        $rules = [
                'id'       => 'required|integer',
            ];
        
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails() || !empty($status)) {

            $validator->errors()->add('', 'La solicitud ya fue tomada.');

            return [
                'success' => false,
                'errors'  => $validator->errors()->all()
            ];
        }
       	
       	// Inserto Movimiento.

		$movement = new Movement();
        $movement->request_id = addslashes($request->input('id'));
        $movement->user_id = auth()->user()->id;
        $movement->state_id = 2;
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

        $current = DB::table('movements')
                    ->where('finalized', '<>', NULL)
                    ->count();

        $movements = DB::table('movements AS m')
            ->join('requests AS r', 'm.request_id', '=', 'r.id')
            ->join('users AS u', 'm.user_id', '=', 'u.id')
            ->join('states AS s', 'm.state_id', '=', 's.id')
            ->select('m.*', 'r.id AS request_id', 'r.description AS request_description', 'r.misc_id AS request_misc_id', 'r.created_at AS request_created_at', 'r.updated_at AS request_updated_at', 'u.last_name', 'u.first_name', 'u.email', 's.name')
            ->where('m.id', $id)
            ->get();

        return $movements;        
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
