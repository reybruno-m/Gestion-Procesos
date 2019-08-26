<template>
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col">
                <h4 class="text-left">Nuevo Origen</h4>
            </div>
        </div>       
        
        <br>
        
        <form class="form-group" method="POST" id="frm-new-origin">
            <div class="row">
                <div class="col">
                    <label for="nombre_origen"><b>Nombre: </b></label>
                    <input type="text" autofocus="" class="form-control" id="nombre_origen" name="nombre_origen" v-model="registry.nombre_origen" tabindex="1">
                </div>
                <div class="col">
                    <label for="tipo_origen"><b>Tipo: </b></label>
                    <select class="form-control" id="tipo_origen" name="tipo_origen" v-model="registry.tipo_origen" tabindex="2">
                        <option disabled="" value="0">Seleccionar</option>
                        <option v-for="tipo in tiposOrigenes" :value="tipo.id">{{tipo.name}}</option>
                    </select>
                </div>
                <div class="col">
                    <label for="estado"><b>Estado: </b></label>
                    <select class="form-control" id="estado_origen" name="estado_origen" v-model="registry.estado_origen" tabindex="3">
                        <option value="active">Activo (Visible)</option>
                        <option value="inactive">Inactivo (Oculto)</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col text-center">
                    <input type="button" class="btn btn-outline-danger" tabindex="5" value="CANCELAR" @click="clearView()" >
                </div>
                <div class="col text-center">
                    <input type="button" class="btn btn-outline-success" tabindex="4" value="CARGAR" @click="saveRegistry()">
                </div>
            </div>
        </form>
        <br><hr>
    </div>
</template>

<script>
    export default {
        props: [
            'registry', // Contiene los elementos de un nuevo registro.
        ],

        data(){
            return {
                tiposOrigenes: [],       // Listado de tipos de origenes "db.misc".
            }
        },

        mounted() {
            this.registry.tipo_origen = 0;
            this.registry.estado_origen = 'active';

            document.getElementById("nombre_origen").focus();
            this.loadOriginTypes();
        },

        methods: {
            /* guarda un registro en la db y lo carga en la vista. */

            saveRegistry: function(){
              if (confirm("Guardar el nuevo origen?")) {

                var datos = this.getDataForm();
                var route = 'origin';

                axios
                  .post(route, datos)
                  .then(response => {
                    alert(response.data.msj);
                      this.$emit('pushData', response.data.elements);
                      this.clearForm();
                  })
                  .catch(error => console.log(error))
                }
            },

            /* Obtiene de la tabla Misc el grupo indicado y lo carga en un select */

            loadOriginTypes: function(){
                axios
                .get('getMisc?group=1')
                .then(listado => {
                    var countObj = Object.keys(listado.data).length;
                    if (countObj > 0) {
                        for (var i = 0; i < countObj; i++) {
                            this.tiposOrigenes.push(listado.data[i]);
                        }
                    }
                })
            },

            /* Obtiene los datos de un formulario especifico */

            getDataForm: function(){
              let datos = new FormData();
              datos.append("nombre_origen", this.registry.nombre_origen);
              datos.append("tipo_origen", this.registry.tipo_origen);
              datos.append("estado_origen", this.registry.estado_origen);
              return datos;
            },

            /* Envia al parent la orden de ocultar el form. */

            clearView: function(){
              this.$emit('clearView', 0);
            },

            /* Recorre y vacia los datos cargados en la vista de un form. */

            clearForm(){
              var self = this;
              Object.keys(this.registry).forEach(function(key,index) {
                self.registry[key] = '';
              });
            },

        },
    }
</script>
