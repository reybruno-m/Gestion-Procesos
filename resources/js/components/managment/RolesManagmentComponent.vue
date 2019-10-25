<template>
	<div class="container-fluid">
		<br><br>
		<h5 class="text-left">Gestion de Roles y Permisos</h5>
		<br>
		<table class="table table-condensed">
			<thead>
				<tr bgcolor="#f3f3f3">
					<th class="text-center">Rol</th>
					<th class="text-left">Descripcion</th>
					<th class="text-center">Usuarios</th>
					<th class="text-center" width="200px">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-center">Usuario</td>
					<td class="text-left">Usuario Normal, sin privilegios extras.</td>
					<td class="text-center">
						<a href="#">Ver Usuarios</a>
					</td>
					<td class="text-center" width="200px">
						<button class="btn btn-sm btn-primary">
							<span class="glyphicon glyphicon-edit"></span>
							Editar
						</button>
						<button class="btn btn-sm btn-danger">
							<span class="glyphicon glyphicon-edit"></span>
							Borrar
						</button>
					</td>
				</tr>
				<tr>
					<td class="text-center">Administrador</td>
					<td class="text-left">Usuario Administrador.</td>
					<td class="text-center">
						<a href="#">Ver Usuarios</a>
					</td>
					<td class="text-center" width="200px">
						<button class="btn btn-sm btn-primary">
							<span class="glyphicon glyphicon-edit"></span>
							Editar
						</button>
						<button class="btn btn-sm btn-danger">
							<span class="glyphicon glyphicon-edit"></span>
							Borrar
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>