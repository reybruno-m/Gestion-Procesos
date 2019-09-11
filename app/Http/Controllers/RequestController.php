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
     }

    public function index()
    {
        $requests = DB::table('requests AS r')
            ->join('misc AS m', 'r.misc_id', '=', 'm.id')
            ->join('users AS u', 'r.user_id', '=', 'u.id')
            ->join('origins AS o', 'r.origin_id', '=', 'o.id')
            ->select('r.*', 'm.id AS pk_misc', 'm.name AS prioridad', 'u.last_name', 'u.first_name', 'u.email', 'o.name AS origen')
            ->orderBy('r.created_at', 'desc')
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
            ->select('r.*', 'm.id', 'm.name AS prioridad', 'u.last_name', 'u.first_name', 'u.email', 'o.name AS origen')
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
