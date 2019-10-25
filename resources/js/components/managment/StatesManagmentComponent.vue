<template>
    <div class="container-fluid">
		<br><br>
		<h5 class="text-left">Gestion de Estados</h5>
		<br>
		<table class="table table-condensed">
			<thead>
				<tr bgcolor="#f3f3f3">
					<th class="text-left">Nombre</th>
					<th class="text-center" width="200px">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left">Inicial</td>
					<td class="text-center" width="200px">
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
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
