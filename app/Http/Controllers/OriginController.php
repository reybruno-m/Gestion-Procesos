<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;

use it\Misc;
use it\Origin;
use DB;

class OriginController extends Controller
{

    public $response = array();


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
        try {
            
            $nombre_origen = ucwords(addslashes($request->input('nombre_origen')));
            $tipo_origen = ucwords(addslashes($request->input('tipo_origen')));
            $estado_origen = addslashes($request->input('estado_origen'));

            if ($nombre_origen == '')
                throw new \Exception("El nombre de origen no puede estar vacio.");

            if (!is_numeric($tipo_origen))
                throw new \Exception("El tipo de origen no puede estar vacio.");

            $origin = new Origin();

            $origin->name = $nombre_origen;
            $origin->misc_id = $tipo_origen;
            $origin->state = $estado_origen;
            $origin->save();

            $this->response['elements'] = $origin;
            $this->response['success'] = true;
            $this->response['msj'] = "Registro guardado con exito.";
            
        } catch (Exception $e) {
            $response['msj'] = $e->getMessage();
        }

        return $this->response;
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

        try {

            $id = addslashes($request->input('id'));
            $action = addslashes($request->input('action'));

            if (!is_numeric($id))
                throw new \Exception("Error, Indice no definido.");

            switch ($action) {
                case 'cambiar_estado':
                    
                    $origin = array();
                    $origin = Origin::findOrFail($id);


                    if ($origin->state == 'active') {
                        $origin->state = 'inactive';
                        $response['msj'] = "Registro Desactivado con exito.";
                    }else{
                        $origin->state = 'active';
                        $response['msj'] = "Registro Activado con exito.";
                    }
                    
                    $origin->save();
                    $this->response['element'] = $origin;
                    $this->response['success'] = true;

                    break;
                
                default:
                    //throw new \Exception("Error, Accion no definida.");
                    break;
            }
            
        } catch (Exception $e) {
            $response['msj'] = $e->getMessage();
        }

        return $this->response;       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            if (!is_numeric($id)) throw new \Exception("El parametro indicado no es correcto.");

            $origin = Origin::find($id);
            $origin->delete();
        
            $this->response['success'] = true;
            $this->response['msj'] = "Origen eliminado con exito.";

        } catch (\Exception $e) {
            $msj = $e->getMessage();
        }

        return $this->response;
    }
}
