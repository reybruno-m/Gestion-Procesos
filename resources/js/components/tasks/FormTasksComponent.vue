<template>
    <div class="container-fluid">
        
        <div class="container-fluid" v-if="errors.length">
            <div class="alert alert-danger" role="alert" v-for="error in errors">
                Por favor verifique: <b>{{ error }}</b>
            </div>
        </div>

		<form class="form-group" id="frm-new-request">
    		<div class="row separator">
    			
    			<div class="col">
    				<label for="origen"><b>Origen: </b></label>
    				<select class="form-control" name="origen" id="origen" v-model="registry.origin_id"  tabindex="1" autofocus="">
    					<option v-for="origen in listOrigins" :value="origen.id" v-if="origen.state == 'active'">{{origen.name}}</option>
    				</select>
    			</div>
    			<div class="col">
    				<label for="priority"><b>Prioridad: </b></label>
    				<select class="form-control" name="priority" id="priority" v-model="registry.misc_id" tabindex="2">
    					<option v-for="prio in listPriority" :value="prio.id">{{prio.name}}<i class="fa fa-circle icon-prio" v-bind:class="prio.name"></i></option>
    				</select>
    			</div>
    		      <div class="col">
                    <label for="destinity_id"><b>Destino: </b></label>
                    <select class="form-control" name="destinity_id" id="destinity_id" v-model="registry.destinity_id"  tabindex="3" autofocus="">
                        <option v-for="destinity_id in listOrigins" :value="destinity_id.id" v-if="destinity_id.state == 'active'">{{destinity_id.name}}</option>
                    </select>
                </div>
    		</div>
    		
    		<br>
    		
    		<div class="row separator">
    			
    			<div class="col">
    				<label for="description"><b>Descripcion: </b></label>
    				<textarea class="form-control" name="description" id="description" v-model="registry.description" tabindex="4" rows="5"></textarea>
    			</div>
    			
    		</div>
			
			<br>
			
			<div class="row separator">
                
                <div class="col text-center">
                    <input 
                        @click="clearView()" 
                        class="btn btn-danger" 
                        tabindex="7" 
                        type="button" 
                        value="CANCELAR" 
                    >
                </div>

                <div class="col text-center" v-if="operation === 1">
                    <input 
                        @click="saveTask()"
                        class="btn btn-success" 
                        tabindex="5" 
                        type="button" 
                        value="CARGAR" 
                    >
                </div>

                <div class="col text-center" v-if="operation === 2">
                    <input 
                        @click="updateTask()"
                        class="btn btn-success" 
                        tabindex="6" 
                        type="button" 
                        value="GUARDAR" 
                    >
                </div>

			</div>
			
			<br>

		</form> 
    </div>
</template>

<script>
    export default {
        
        props: [
            'operation',    // Configura la vista en base a si se esta editando, creando o listando los elementos.
            'registry',     // Contiene los elementos de un nuevo registro.
        ],

        data()
        {
            return {
                listOrigins: [],   	// Listado de tipos de origenes "db.origins".
                listPriority: [],   // Listado de tipos de prioridades "db.misc"
                errors: [],         // Registra errores, para la validacion.
            }
        },

        mounted() {
        	this.loadOrigins();
    		this.loadpriority();
            document.getElementById("origen").focus();
        },

        methods:{

            // Guarda un registro en la db y lo carga en la vista.
            saveTask ( ) {
                var datos = this.getDataForm();
                if (!this.validateForm(datos).length) {
                    var route = 'api/task';
                    axios
                    .post(route, datos)
                    .then(res => {
                        if (res.data.success) {
                            this.$emit('pushData', res.data.elements);
                            this.clearForm();
                        }else{
                            this.validateForm(res.data.errors, true)
                        }
                    })
                }
            },

            // Valida el formulario de carga/edicion.
            validateForm ( e, axios = false ){
                this.errors = [];

                // valida respuesta de axios.

                if (axios) {
                    for (var i = 0; i < e.length; i++) {
                        this.errors.push(e[i])
                    }
                    return "";
                }
                
                // valida formulario html.

                this.data = this.registry;

                if (this.data.origin_id && this.data.misc_id && this.data.description) {
                    return this.errors;
                }

                if (!this.data.origin_id) {
                    this.errors.push('Origen requerido.');
                }

                if (!this.data.misc_id) {
                    this.errors.push('Prioridad requerida.');
                }

                if (!this.data.destinity_id) {
                    this.errors.push('La tarea debe estar asignada a un sector o persona');
                }

                if (!this.data.description) {
                    this.errors.push('Descripcion requerida.');
                }

                return this.errors;
            },

            // Obtiene los datos de un formulario especifico. 
            getDataForm ( ) {
                let datos = new FormData();
                datos.append("origin_id", this.registry.origin_id);
                datos.append("misc_id", this.registry.misc_id);
                datos.append("destinity_id", this.registry.destinity_id);
                datos.append("description", this.registry.description);
                return datos;
            },

            // Envia al parent la orden de ocultar el form.
            clearView ( ) {
                this.$emit( 'clearView', 0 );
            },
            
            //  Carga un el listado de origenes en un array;
            loadOrigins ( ) {
                axios
                .get('api/origin')
                .then(listado => {
                    var countObj = Object.keys(listado.data).length;
                    if (countObj > 0) {
                        for (var i = 0; i < countObj; i++) {
                            this.listOrigins.push(listado.data[i]);
                        }
                    }
                })
            },

            //  Carga un el listado de prioridades en un array;
            loadpriority ( ) {
                axios
                .get('api/getMisc?group=2')
                .then(listado => {
                    var countObj = Object.keys(listado.data).length;
                    if (countObj > 0) {
                        for (var i = 0; i < countObj; i++) {
                            this.listPriority.push(listado.data[i]);
                        }
                    }
                })
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
