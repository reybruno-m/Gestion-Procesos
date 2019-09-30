<template>
    <div class="div-padre">
        
        <br>
        
        <div class="row">
            <div class="col alert alert-info">
                <h4 class="text-left" v-if="operation === 1">Nuevo Origen</h4>
                <h4 class="text-left" v-else>Editar Origen</h4>
            </div>
        </div>      

        <br>

        <div class="container-fluid" v-if="errors.length">
            <div class="alert alert-danger" role="alert" v-for="error in errors">
                Por favor verifique: <b>{{ error }}</b>
            </div>
        </div>

        <br>
        
        <form class="form-group" method="POST" id="frm-new-origin">
            
            <div class="row">
                
                <div class="col">
                    <label for="name"><b>Nombre: </b></label>
                    <input 
                        autofocus="" 
                        class="form-control" 
                        id="name" 
                        name="name" 
                        tabindex="1"
                        type="text" 
                        v-model="registry.name" 
                        placeholder="Ej. Contabilidad" 
                    >
                </div>

                <div class="col">
                    <label for="misc_id"><b>Tipo: </b></label>
                    <select 
                        class="form-control" 
                        id="misc_id" 
                        name="misc_id" 
                        tabindex="2"
                        v-model="registry.misc_id" 
                    >
                        <option v-for="tipo in typesOrigins" :value="tipo.id">{{tipo.name}}</option>
                    </select>
                </div>

                <div class="col">
                    <label for="estado"><b>Estado: </b></label>
                    <select 
                        class="form-control" 
                        id="state" 
                        name="state" 
                        tabindex="3"
                        v-model="registry.state" 
                    >
                        <option value="active">Activo (Visible)</option>
                        <option value="inactive">Inactivo (Oculto)</option>
                    </select>
                </div>

            </div>

            <br>

            <div class="row">

                <div class="col text-center">
                    <input 
                        @click="clearView()" 
                        class="btn btn-danger" 
                        tabindex="5" 
                        type="button" 
                        value="CANCELAR" 
                    >
                </div>

                <div class="col text-center" v-if="operation === 1">
                    <input 
                        @click="saveOrigin()"
                        class="btn btn-success" 
                        tabindex="4" 
                        type="button" 
                        value="CARGAR" 
                    >
                </div>

                <div class="col text-center" v-if="operation === 2">
                    <input 
                        @click="updateOrigin()"
                        class="btn btn-success" 
                        tabindex="4" 
                        type="button" 
                        value="GUARDAR" 
                    >
                </div>

            </div>

        </form>

        <br><br>

    </div>

</template>

<script>
    export default 
    {
        props: [
            'operation',    // Configura la vista en base a si se esta editando, creando o listando los elementos.
            'registry',     // Contiene los elementos de un nuevo registro.
            'listOrigins',
        ],

        data()
        {
            return {
                typesOrigins: [],   // Listado de tipos de origenes "db.misc".
                errors: [],         // Registra errores, para la validacion.
            }
        },

        mounted(){
            this.registry.state = 'active';
            document.getElementById("name").focus();
            this.loadTypesOrigin();
        },

        methods: 
        {
            // Guarda un registro en la db y lo carga en la vista.
            saveOrigin ( ) {
                var datos = this.getDataForm();
                if (!this.validateForm(datos).length) {
                    var route = 'origin';
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
                    .catch(error => {
                        console.log(error.message)
                    })
                }
            },
            // Actualiza un registro en la db y en la vista.
            updateOrigin ( ) {
                const datos = this.getDataForm();
                var response = this.inArray(this.registry.misc_id, this.typesOrigins);
                this.registry.misc_name = response.name;

                if (!this.validateForm(datos).length) {
                    datos.append("_method", "PATCH");
                    datos.append("id", this.registry.id);
                    var route = 'origin/' + this.registry.id;

                    axios
                    .post(route, datos)
                    .then(response => {
                        if (response.data.success) {
                            this.$emit('updateView');
                        }
                    })
                    .catch(error => console.log(error))
                }
            },
            //  Carga un grupo especifico de Misc en arreglo;
            loadTypesOrigin ( ) {
                axios
                .get('getMisc?group=1')
                .then(listado => {
                    var countObj = Object.keys(listado.data).length;
                    if (countObj > 0) {
                        for (var i = 0; i < countObj; i++) {
                            this.typesOrigins.push(listado.data[i]);
                        }
                    }
                })
            },
            // Obtiene los datos de un formulario especifico. 
            getDataForm ( ) {
                let datos = new FormData();
                datos.append("name", this.registry.name);
                datos.append("misc_id", this.registry.misc_id);
                datos.append("state", this.registry.state);
                return datos;
            },
            // Valida el formulario de carga/edicion.
            validateForm ( e, axios = false ){
                this.errors = [];
                // VALIDA BACK.
                if (axios) {
                    for (var i = 0; i < e.length; i++) {
                        this.errors.push(e[i])
                    }
                    return "";
                }
                // VALIDA FRONT.
                this.data = this.registry;
                if (this.data.name && this.data.misc_id && this.data.state) {
                    return this.errors;
                }
                if (!this.data.name) {
                    this.errors.push('Nombre requerido.');
                }
                if (!this.data.misc_id) {
                    this.errors.push('Tipo requerido.');
                }
                if (!this.data.state) {
                    this.errors.push('Estado requerido.');
                }
                return this.errors;
            },
            // Envia al parent la orden de ocultar el form.
            clearView ( ) {
                this.$emit( 'clearView', 0 );
            },
            // [GLOBAL] Recorre y vacia los datos cargados en la vista de un form.
            clearForm ( ) {
                var self = this;
                Object.keys(this.registry).forEach(function(key,index) {
                    self.registry[key] = '';
                });
            },
            // [GLOBAL] verifica si existe un elemento en un array y lo devuelve.
            inArray ( needle, haystack ) {
                var length = haystack.length;
                for(var i = 0; i < length; i++) {
                    if(haystack[i].id == needle) return haystack[i];
                }
                return false;
            },

        }, // Methods.
    }
</script>

<style type="text/css">
    .div-padre{
        width: 100%;
    }
</style>