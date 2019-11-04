<template>
	<div>
		<!-- Menu de navegacion general -->
		<nav class="navbar navbar-expand-lg navbar-light navbar-pers">
			<a class="navbar-brand" href="/inicio"></a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse main" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<router-link class="link" style="text-decoration:none" :to="{ name: 'inicio' }">Inicio</router-link>
					</li>
					<li class="nav-item">
						<router-link class="link" style="text-decoration:none" v-bind:to="{ name: 'tareas' }">Tareas</router-link>
					</li>
					<li class="nav-item">
						<router-link class="link" style="text-decoration:none" :to="{ name: 'reportes' }">Reportes</router-link>
					</li>
					<li class="nav-item">
						<router-link class="link" style="text-decoration:none" :to="{ name: 'origenes' }">Origenes</router-link>
					</li>
				</ul>
			</div>
			
		</nav>
		
		<!-- Carga Dinamica de componentes -->
		<router-view></router-view>

	</div>
</template>


<style type="text/css">
	.navbar-pers{
		-moz-box-shadow: 7px 4px 17px -6px rgba(176,169,176,1);
		-webkit-box-shadow: 7px 4px 17px -6px rgba(176,169,176,1);
		background: #4285F4;
		box-shadow: 7px 4px 17px -6px rgba(176,169,176,1);
	}
	.link{
		padding: 14px 10px 14px 10px;
		color: white;
		font-size: 17px;
	}
	.link:hover{
		color: #EEEEEE;
		outline: none !important;		
	}
	.router-link-exact-active{
		background: #FF3547;
		padding: 14px 10px 14px 10px;
	}
	
</style>