<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;
use it\Comment;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $errors = [];

        $id = addslashes(trim($request->input('id')));
        $comentario = addslashes(trim($request->input('comment')));

        if (!is_numeric($id)) {
            $errors[] = "Ocurrio un error mientras se procesaba la solicitud.";
            return [ 'success' => false, 'errors'  => $errors ];
        }

        if (strlen($comentario) == 0 || $comentario == "" || $comentario == "undefined") {
            $errors[] = "El comentario no puede estar vacio.";
            return [ 'success' => false, 'errors'  => $errors ];
        }

        $comment = new Comment();
        $comment->movement_id = $id; 
        $comment->user_id = auth()->user()->id;
        $comment->comment = $comentario;
        $comment->save();

        $comment = Comment::with(
                        'user'   # Usuarios de los comentarios.
                    )
                ->where('id', '=', $comment->id)
                ->first();

        return [
            'success' => true,
            'comment' => $comment,
        ];
    }
}
