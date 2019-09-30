<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

	<title>@yield('title', 'Default') | Gestion - Procesos</title>

	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
	
	<link rel="stylesheet" href="{{ asset('libs/jquery/css/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ asset('libs/bootstrap4/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('libs/bootstrap4/css/bootstrap-select.min.css') }}" />

</head>
<body>

@include('layouts.navbar')


<section>
	@yield('content')
</section>

@include('layouts.footer')

@yield('scripts')
	
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/jquery/js/jquery-3.4.0.min.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/jquery/js/jquery-ui.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/bootstrap4/js/bootstrap.min.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/bootstrap4/js/bootstrap.bundle.min.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/bootstrap4/js/bootstrap-select.min.js') }}"></script>


	<script language="JavaScript" type="text/javascript" src="{{asset('js/app.js')}}"></script>

</body>
</html>
