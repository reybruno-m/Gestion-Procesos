<template>
	<div>
		
		<div class="container">
	    	
			<br>
				<h6 class="text-muted">Tarea a Realizar </h6>
			<br>

	    	<!-- Descripcion de la tarea a realizar -->
			<div class="row">
				<div class="col">
					<div class="card">
					  <div class="card-body bg-light">
					  	<h6>
				  			Asignada a <span class="title-task"> <b>{{ tarea_destino }}</b></span> 
							<i class="creado">{{ tarea_fcreacion }}</i>
				  		</h6>
						<br>
					    <p class="card-text">{{ tarea_descripcion }}</p>
						<i class="text-muted">Tarea Creada por <b>{{ tarea_usuario }}</b></i>
					  </div>
					</div>
				</div>
			</div><!-- / Descripcion de la tarea a realizar -->

			<br>
				<h6 class="text-muted">Movimientos de la Tarea </h6>
			<br>

			<!-- Movimientos de la tarea -->
			<div class="row separate" v-for="(m, index_mov) in movimientos" :key="m.id" v-if="m.state_id != 1">
				<div class="col">
					
					<div class="card">
					  
					  <div class="card-body bg-light">
					  	
					  	<h6>
					  		<b>{{ m.user.first_name +" "+ m.user.last_name }}</b>
							<i class="creado"> Iniciado: {{ m.taken | formatDateMov }}</i>
							<br>
							<i class="finalizado" v-if="m.finalized != null"> Cerrado: {{ m.finalized | formatDateMov }} </i>
					  	</h6>
						
						<!-- Comentarios del movimiento -->
					    <ul class="timeline" v-if="m.comments.length > 0">
							<li v-for="(c, index_comment) in m.comments" :key="c.id">
								<h6>{{ c.user.last_name +" "+ c.user.first_name }}</h6>
								<p>{{ c.comment }}</p>
								<i class="text-muted">{{ c.created | formatDate }}</i>
							</li>
						</ul>

						<div class="row" v-else>
							<div class="col">
								<p class="text-muted"><i>Sin comentarios para mostrar.</i></p>
							</div>
						</div><!-- / Comentarios del movimiento -->

						<br>

						<!-- Conclusion movimiento -->
					  	<h6>
					  		<b>Observaci&oacute;n</b>
					  	</h6><!-- / Conclusion movimiento -->

						<p class="card-text" v-if="m.description != null">{{ m.description }}</p>
						<p class="card-text text-muted" v-else><i>Sin observaciones para mostrar.</i></p>
						<i class="text-muted f-right" v-if="m.finalized != null">Movimiento finalizado por <b>{{ m.user.last_name +" "+ m.user.first_name}}</b></i>
						
						<br>

						<!-- Formulario Nuevo Comentario -->
						<div class="container-fluid" v-if="operation == m.id">
							<br>
							<form class="form-group" id="frm-comment">
								<textarea 
									class="form-control" 
									name="comment" 
									id="comment" 
									rows="2" 
									placeholder="Ingresar Comentario"
									v-model="registry.comment"
									autofocus="" 
								></textarea>	
							</form>

						</div><!-- / Formulario Nuevo Comentario -->


						<!-- Formulario Observacion cierre -->
						<div class="container-fluid" v-if="operation == m.id+1">
							<br>
							<form class="form-group" id="frm-finish-mov">
								<div class="row">
									<div class="col">
										<select class="form-control input-sm" name="state" id="state" v-model="registry.state">
											<option value="0" selected="">ESTADO DE CIERRE</option>
											<option value="5">FINALIZADO</option>
											<option value="4">PAUSADO</option>
											<option value="6">RECHAZADO</option>
										</select>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col">
										<textarea 
											class="form-control" 
											name="observacion" 
											id="observacion" 
											rows="2" 
											placeholder="Observacion Movimiento"
											v-model="registry.observacion"
											autofocus="" 
										></textarea>	
									</div>
								</div>

							</form>

						</div><!-- / Formulario Observacion cierre -->
						

						<!-- Acciones sobre el movimiento -->
						<div class="row" v-if="m.finalized == null">
							<div class="col text-right">
								<button class="btn btn-sm btn-danger" @click="cancelAction()" v-if="operation != 0" tabindex="2">
				    				CANCELAR
				    			</button>
				    			<button class="btn btn-sm btn-primary" @click="saveNewComment(m.id, index_mov)" v-if="operation == m.id" tabindex="1">
				    				GUARDAR
				    			</button>
								<button class="btn btn-sm btn-primary" @click="showNewComment(m.id)" v-if="operation == 0">
				    				COMENTAR
				    			</button>
				    			<button class="btn btn-sm btn-danger" @click="showFinishMovement(m.id)" v-if="operation == 0" tabindex="3">
				    				FINALIZAR
				    			</button>
				    			<button class="btn btn-sm btn-primary" @click="saveFinishMovement(m.id, index_mov)" v-if="operation == m.id + 1" tabindex="4">
				    				FINALIZAR
				    			</button>
							</div>
						</div><!-- / Acciones sobre el movimiento -->

					  </div>
					</div>
				</div>
			</div><!-- / Movimientos de la tarea -->
			
			<br>

			<!-- Errores -->
	        <div class="row" v-if="errors.length">
	        	<div class="col">
	        		<h6 class="text-danger" v-for="error in errors">Por favor verifique: <b>{{ error }}</b></h6>
	        	</div>
	        </div><!-- / Errores -->

			<br>

	    	<!-- Acciones sobre la tarea -->
	    	<div class="row text-center">
	    		<div class="col text-center">
					<router-link class="link" style="text-decoration:none" v-bind:to="{ name: 'tareas' }">
						<button class="btn btn-outline-danger btn-sm" tabindex="1">
		    				REGRESAR
		    			</button>
					</router-link>
	    		</div>
	    		<div class="col text-center">
				  	<button
				  		type="button" 
				  		@click="takeTask()" 
				  		class="btn btn-outline-dark btn-sm"
				  		v-if="movimientos[movimientos.length -1].finalized != null || movimientos.length == 1"
				  	>TOMAR TAREA</button>
                    <!-- v-if="m[m.length -1].finalized != null || m.length == 1"  -->
				</div>
	    		<div class="col text-center">
	    			<button 
		    			class="btn btn-outline-success btn-sm" 
		    			@click="finalizedTask()" 
		    			tabindex="3"
	    			>FINALIZAR TAREA</button>
	    		</div>
	    	</div><!-- / Acciones sobre la tarea -->
		
		</div>
    	<br><br><br>
	</div>

</template>

<script type="text/javascript">
	export default{
		data()
		{
			return {
				id : '',						// Indice de entrada de la tarea. se recibe por url.
				tarea_destino : '',				
				tarea_descripcion : '',
				tarea_usuario : '',
				tarea_fcreacion : '',
				movimientos : [],				// Listado de movimientos y sus relaciones.
				operation: 0,					// Estado de Operacion, muestra u oculta formularios 
                registry: [],                   // Datos del origen nuevo/edicion. 'registry', 
                errors: [],         			// Registra errores, para la validacion.
			}
		},

        mounted()
        {
        	this.id = this.$route.params.id;

        	if (this.id != '') {
	        	this.loadDetail();
        	}

        }, 

		methods: 
        {
            // Mostrar los detalles de una tarea especifica.
            loadDetail(){
                axios
                .get( 'api/task/' + this.id )
                .then(res => {
                    // Datos de la tarea
					this.tarea_destino = res.data.destinity.name;
					this.tarea_descripcion = res.data.description;
					this.tarea_usuario = res.data.user.last_name +" "+res.data.user.first_name + " (" + res.data.origin.name + ")";
					this.tarea_fcreacion = res.data.created_at;
					// Datos de los movimientos.
					for (var i = 0; i < res.data.movements.length; i++) 
					{
						this.movimientos.push(res.data.movements[i]);
					}
                })
            },

			takeTask(data, index){
                if (confirm("Desea Tomar la Tarea seleccionada?")) {
                    let params = new FormData();
                    params.append("id", this.id);
                    
                    axios
                    .post('api/addMovement', params)
                    .then(response => {
                        if (response.data.success) {
                            alert("Tarea tomada con exito.");
                            this.movimientos.push(response.data.elements);
                        }else{
                            alert(response.data.errors[0]);
                        }
                    })
                    .catch(error => console.log(error))
                } 
            },

            // Despliega el formulario de carga de un nuevo comentario.
            showNewComment( id_movement ){
            	this.operation = id_movement;
            },

            // Cancela la carga, oculta el formulario de carga / finalizacion.
			cancelAction(){
				this.operation = 0;
				this.errors = [];
			},

			// Procesa el guardado y actualizacion de la vista de un nuevo comentario.
			saveNewComment( id_movement, index ){
				let datos = new FormData();
                datos.append("id", id_movement);
                datos.append("comment", this.registry.comment);
				
				if (!this.validateForm(datos, false, 'comentario').length) {
	                axios
	                .post('api/comment', datos)
	                .then(res => {
	                    if (res.data.success) {
	                    	this.movimientos[index].comments.push(res.data.comment);
	                        this.clearForm();
	                        this.cancelAction();
	                    }else{
	                        this.validateForm(res.data.errors, true);
	                    }
	                })
                }
			},

            // Despliega el formulario de carga para el cierre del movimiento.
			showFinishMovement( id_movement ){
				this.operation = id_movement + 1;
                this.registry.state = 0;
			},

			// Procesa la finalizacion y actualizacion de la vista al cerrar el movimiento.
			saveFinishMovement( id_movement, index ){
				
				let datos = new FormData();
                datos.append("observacion", this.registry.observacion);
                datos.append("state", this.registry.state);
                datos.append("_method", "PATCH");
				
				if (!this.validateForm(datos, false, 'finalizar').length) {
	                axios
	                .post('api/movement/' + id_movement, datos)
	                .then(res => {
	                    if (res.data.success) {
	                    	this.movimientos[index] = res.data.movement;
	                        this.clearForm();
	                        this.cancelAction();
	                    }else{
	                        this.validateForm(res.data.errors, true);
	                    }
	                })
                }
			},

			// Finaliza la area completa.
			finalizedTask(){

			},

			// Valida el formulario de carga.
			validateForm ( e, axios = false, accion = null ){
                this.errors = [];

                // valida respuesta de axios.
                if (axios) {
                    for (var i = 0; i < e.length; i++) {
                        this.errors.push(e[i])
                    }
                    return "";
                }
                
                this.data = this.registry;
                
                switch(accion){
                	case 'comentarios':
		                if (!this.data.comment) {
		                    this.errors.push('El comentario no puede estar vacio.');
		                }
            		break;

                	case 'finalizar':
		                if (!this.data.observacion) {
		                    this.errors.push('La observacion no puede estar vacia.');
		                }
		                if (!this.data.state) {
		                	this.errors.push('Debe indicar el estado final del movimiento');
		                }
            		break;
                }

                return this.errors;
            },
 			
 			// [GLOBAL] Recorre y vacia los datos cargados en la vista de un form.
            clearForm ( ) {
                var self = this;
                Object.keys(this.registry).forEach(function(key,index) {
                    self.registry[key] = '';
                });
            },
        }
	}
</script>

<style>
	ul.timeline {
	    list-style-type: none;
	    position: relative;
	    width: 100%;
	}
	ul.timeline:before {
	    background: #d4d9df;
	    content: ' ';
	    display: inline-block;
	    height: 100%;
	    left: 29px;
	    position: absolute;
	    width: 2px;
	    z-index: 400;
	}
	ul.timeline > li {
	    margin: 20px 0;
	    padding-left: 20px;
	}
	ul.timeline > li:before {
	    background: white;
	    border-radius: 50%;
	    border: 2px solid #4285F4;
	    content: ' ';
	    display: inline-block;
	    height: 15px;
	    left: 20px;
	    margin-top: 3px;
	    position: absolute;
	    width: 15px;
	    z-index: 400;
	}
	ul.timeline > li h6, .title-task{
		color:#4285F4;
	}
	.creado{ 
		float: right; 
		color: green;
	}
	.finalizado{ 
		float: right; 
		padding: 0px 3px 0px 3px;
		color: red;
	}
	.separate{
		margin-bottom: 30px;
	}
	.f-right{
		float: right;
	}
</style>