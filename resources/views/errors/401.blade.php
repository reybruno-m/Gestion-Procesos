@extends('layouts.header')

@section('title', 'No Autorizado')

@section('content')

<div class="fixedContainer text-center">
	
	<br><br><br>
	<img src="{{asset('img/401.png')}}" width="100px">
	<br><br>
	<h4 class="text-center">Error 401 Acceso No Autorizado</h4>
	<h5>El usuario no cuenta con los privilegios necesarios para acceder a esta seccion.</h5>
	<br><br>
	<a href="/inicio">Regresar al Inicio</a>
	
</div>

@endsection
