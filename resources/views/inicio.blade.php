@extends('layouts.header')

@section('title', 'Inicio')

@section('content')

	<div class="fixedContainer" id="workspace">
				
		@if(Auth::check())
			<module><!-- Area de carga de Componentes --></module>	
		@endif

	</div>

@endsection

<script>
   window.Laravel = {!! json_encode([
       'csrfToken' => csrf_token(),
       'apiToken' => $currentUser->api_token ?? null,
   ]) !!};
</script>
