<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;
//use it\User;
//use it\Departament;
//use it\Task;
use it\Movement;

class TestingController extends Controller
{
    public function index($id){
        $movement = Movement::with(
                        'user',           # Usuarios de cada Movimiento.
                        'state',          # Estado de cada Movimiento.
                        'comments',       # Comentarios de cada Movimiento.
                        'comments.user'   # Usuarios de los comentarios.
                    )
                ->where('id', '=', $id)
                ->first();
        dd($movement);
    }
}
