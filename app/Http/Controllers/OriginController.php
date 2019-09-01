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
        try {
            
            $name = ucwords(addslashes($request->input('name')));
            $misc_id = ucwords(addslashes($request->input('misc_id'))); # ID
            $state = addslashes($request->input('state'));

            if ($name == '')
                throw new \Exception("El nombre de origen no puede estar vacio.");

            if (!is_numeric($misc_id))
                throw new \Exception("El tipo de origen no puede estar vacio.");

            $misc_tipo = Misc::find($misc_id);

            $origin = new Origin();

            $origin->name = $name;
            $origin->misc_id = $misc_id;
            $origin->state = $state;
            $origin->save();

            $origin->misc_name = $misc_tipo->name;

            $this->response['elements'] = $origin;
            $this->response['success'] = true;
            $this->response['msj'] = "Registro guardado con exito.";
            
        } catch (Exception $e) {
            $this->response['msj'] = $e->getMessage();
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

            $origin = array();
            $origin = Origin::findOrFail($id);

            switch ($action) 
            {
                case 'cambiar_estado':
                
                    if ($origin->state == 'active') {
                        $origin->state = 'inactive';
                        $this->response['msj'] = "Registro Desactivado con exito.";
                    }else{
                        $origin->state = 'active';
                        $this->response['msj'] = "Registro Activado con exito.";
                    }

                    break;

                case 'actualizar_datos':

                    $name = addslashes(ucwords($request->input('name')));
                    $misc_id = addslashes($request->input('misc_id'));
                    $state = addslashes(strtolower($request->input('state')));

                    if ($name == "") throw new \Exception("El nombre del origen no puede estar vacio");
                    if (!is_numeric($misc_id)) throw new \Exception("El tipo de origen no puede estar vacio");
                    if ($state == "") throw new \Exception("El estado de origen no puede estar vacio");
                    
                    $origin->name = $request->input('name');
                    $origin->misc_id = $request->input('misc_id');
                    $origin->state = $request->input('state');

                    break;
                
                default:
                    //throw new \Exception("Error, Accion no definida.");
                    break;
            }

            $origin->save();
            $this->response['element'] = $origin;
            $this->response['success'] = true;
            
        } catch (Exception $e) {
            $this->response['msj'] = $e->getMessage();
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
