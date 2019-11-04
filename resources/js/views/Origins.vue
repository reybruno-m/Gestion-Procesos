<template>
	<div>
        <title>{{ $route.meta.title }}</title>

       	<br>

        <div class="jumbotron jumbotron-fluid">
          <div class="container text-center">
            <h2 class="display-4">Origenes</h2>
            <p class="lead">Listado de origenes actualmente cargados.</p>
          </div>
        </div>

		<list-origins-component></list-origins-component>
	</div>
</template>