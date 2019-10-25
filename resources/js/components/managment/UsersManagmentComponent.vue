<template>
    <div class="container-fluid">
		<br><br>
		<h5 class="text-left">Gestion de Usuarios</h5>
		<br>
		<table class="table table-condensed">
			<thead>
				<tr bgcolor="#f3f3f3">
					<th class="text-center">Apellido</th>
					<th class="text-center">Nombre</th>
					<th class="text-center">Email/Usuario</th>
					<th class="text-center">Clave</th>
					<th class="text-center">Nivel</th>
					<th class="text-center">Creado</th>
					<th class="text-center">Modificado</th>
					<th class="text-center">Tipo de Usuario</th>
					<th class="text-center" width="200px">Acciones</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td class="text-center">Rey</td>
					<td class="text-center">Bruno Martin</td>
					<td class="text-center">brunomartinrey@gmail.com</td>
					<td class="text-center">
						<a href="#">Blanquear Clave</a>
					</td>
					<td class="text-center">Administrador</td>
					<td class="text-center">27-10-2019 14:50</td>
					<td class="text-center">27-10-2019 16:45</td>
					<td class="text-center">Usuario Normal</td>
					<td class="text-center" width="200px">
						<button class="btn btn-sm btn-primary width">
							<span class="glyphicon glyphicon-edit"></span>
							Editar
						</button>
						<button class="btn btn-sm btn-danger width">
							<span class="glyphicon glyphicon-edit"></span>
							Borrar
						</button>
					</td>
				</tr>
			</tbody>
		</table>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component Usuarios Montado.')
        }
    }
</script>

<style type="text/css">
	.width{
		display: inline-block;
	}
</style>
