<template>
    <div class="container-fluid">
    	<div class="row">
			<div class="col">
				<br><br>
				<h5 class="text-left">Categorias de Origenes</h5>
				<br>
				<table class="table table-hovered">
					<thead>
						<tr bgcolor="#f3f3f3">
							<th class="text-center">Nombre</th>
							<th class="text-center">Estado</th>
							<th class="text-center" width="200px">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center">Persona</td>
							<td class="text-center">En Uso</td>
							<td class="text-center" width="200px">
								<button class="btn btn-sm btn-primary" disabled="">
									Editar
								</button>
								<button class="btn btn-sm btn-danger" disabled="">
									Borrar
								</button>
							</td>
						</tr>
						<tr>
							<td class="text-center">Sector/Seccion</td>
							<td class="text-center">Libre</td>
							<td class="text-center">
								<button class="btn btn-sm btn-primary">
									Editar
								</button>
								<button class="btn btn-sm btn-danger">
									Borrar
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col">
				<br><br>
				<h5 class="text-left">Prioridades</h5>
				<br>
				<table class="table table-hovered">
					<thead>
						<tr bgcolor="#f3f3f3">
							<th class="text-center">Nombre</th>
							<th class="text-center">Color</th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-center">Baja</td>
							<td class="text-center">#d21d3f</td>
							<td class="text-center">
								<button class="btn btn-sm btn-primary" disabled="">
									Editar
								</button>
								<button class="btn btn-sm btn-danger" disabled="">
									Borrar
								</button>
							</td>
						</tr>
						<tr>
							<td class="text-center">Intermedia</td>
							<td class="text-center">#f133f1a</td>
							<td class="text-center">
								<button class="btn btn-sm btn-primary">
									Editar
								</button>
								<button class="btn btn-sm btn-danger">
									Borrar
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
    	</div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
