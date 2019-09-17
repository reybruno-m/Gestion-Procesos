<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;
use it\Misc;
use it\User;
use it\Origin;
use DB;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->response['msj'] = "";
        $this->response['success'] = false;
    }

    public function index()
    {
        $requests = DB::table('requests AS r')
            ->join('misc AS m', 'r.misc_id', '=', 'm.id')
            ->join('users AS u', 'r.user_id', '=', 'u.id')
            ->join('origins AS o', 'r.origin_id', '=', 'o.id')
            ->select('r.*', 'm.id AS pk_misc', 'm.name AS prioridad', 'u.last_name', 'u.first_name', 'u.email', 'o.name AS origen')
            ->orderBy('r.id', 'desc')
            ->get();

        return $requests;        
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
            'origin_id.integer' => 'Debe seleccionar un origen del listado.',
            'description.min' =>'La descripcion debe contener al menos 10 caracteres.',
            'misc_id.required' => 'Debe seleccionar una prioridad del listado.',
            'misc_id.integer' => 'Debe seleccionar una prioridad del listado.',
        ];

        // Reglas de validación.
        $rules = [
                'origin_id'     => 'required|integer',
                'description'   => 'required|min:10',
                'misc_id'       => 'required|integer',
            ];
        
        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors'  => $validator->errors()->all()
            ];
        }

        DB::table('requests')->insert(
            [
                'description' => addslashes($request->input('description')), 
                'misc_id' => $request->input('misc_id'),
                'user_id' => auth()->user()->id,
                'origin_id' => $request->input('origin_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]   
        );

        $elements = DB::table('requests AS r')
            ->join('misc AS m', 'r.misc_id', '=', 'm.id')
            ->join('users AS u', 'r.user_id', '=', 'u.id')
            ->join('origins AS o', 'r.origin_id', '=', 'o.id')
            ->select('r.*', 'm.id AS misc_pk', 'm.name AS prioridad', 'u.last_name', 'u.first_name', 'u.email', 'o.name AS origen')
            ->orderBy('created_at', 'desc')
            ->first();

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
        $requests = DB::table('requests AS r')
            ->join('misc AS m', 'r.misc_id', '=', 'm.id')
            ->join('users AS u', 'r.user_id', '=', 'u.id')
            ->join('origins AS o', 'r.origin_id', '=', 'o.id')
            ->select('r.*', 'm.id AS misc_pk', 'm.name AS prioridad', 'u.last_name', 'u.first_name', 'u.email', 'o.name AS origen')
            ->where('r.id', $id)
            ->get();

        dd($requests);        
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
        //
    }
}
