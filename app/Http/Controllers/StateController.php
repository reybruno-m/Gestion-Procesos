<?php

namespace it\Http\Controllers;

use Illuminate\Http\Request;
use it\State;

class StateController extends Controller
{
    public function index(){
    	return State::all();
    }
}
