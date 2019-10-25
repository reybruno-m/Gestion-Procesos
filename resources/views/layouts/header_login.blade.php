<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

	<title>@yield('title', 'Default') | La Mejor Opci&oacute;n</title>

	<!-- JQUERY -->
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/jquery/js/jquery-3.4.0.min.js') }}"></script>
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/jquery/js/jquery-ui.js') }}"></script>
	<link rel="stylesheet" src="{{ asset('libs/jquery/css/jquery-ui.css') }}">

	<!-- BOOTSTRAP4	-->
	<link rel="stylesheet" src="{{ asset('libs/bootstrap4/css/bootstrap.min.css') }}">
	<script language="JavaScript" type="text/javascript" src="{{ asset('libs/bootstrap4/js/bootstrap.min.js') }}"></script>

	<!-- CSS PROPIOS -->
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.login.css') }}">

</head>
<body>

@include('layouts.navbar')

<section>
	@yield('content')
</section>

@include('layouts.footer')

@yield('scripts')

</body>
</html>
