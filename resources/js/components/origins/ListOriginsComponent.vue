<template>
    <div class="container-fluid">

        <form-origins-component
          :listElements="listElements" 
          :operation = this.operation
          :registry = 'dataReg'
          @cerrar = "operation = 0"
          @clearView="clearView"
          @pushData="pushData"
          v-if="this.operation > 0"
        ></form-origins-component>

        <br>

        <div class="row">
            <div class="col text-left">
                <h4 class="text-left">Origenes Actualmente Cargados</h4>
            </div>
            <div class="col text-right">
                <button type="button" name="button" class="btn btn-sm btn-info" @click="clearView(1)">NUEVO ORIGEN</button>
                <a href="#" class="btn btn-outline-success btn-sm">Imprimir Listado</a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <input type="text" class="form-control input-sm" name="busqueda" placeholder="Filtrar Datos" v-model="term" autofocus="">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-left">Nombre</th>
                            <th class="text-center" width="200px">Tipo</th>
                            <th class="text-center" width="170px">Creado</th>
                            <th class="text-center" width="150px">Acciones</th>
                        </tr>
                    </thead>

                    <tbody v-if="success" >
                        <tr v-for="(element, index) in arrayFilter" :key="element.id">
                            <td class="text-left">{{element.name}}</td>
                            <td class="text-center">{{element.misc_name}}</td>
                            <td class="text-center">{{element.created_at}}</td>
                            <td class="text-center">
                                <input type="button" class="btn btn-sm btn-outline-primary" @click="" value="Editar">
                                <input type="button" class="btn btn-sm btn-outline-danger" @click="" value="Borrar">
                            </td>
                        </tr>
                    </tbody>

                    <tfoot v-else>
                        <tr>
                            <th colspan="4" class="text-center">
                                Sin resultados para mostrar
                                <a href="#" @click="clearView(1)">Cargar Uno</a>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <hr>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                success: false,         // true <- muestra listado | false <- muestra mjs sin resultados.
                operation: 0,           // 0 listado, 1 alta, 2 edita.
                dataReg: [],            // Datos del cliente nuevo. 'registry'
                listElements: [],       // Listado de clientes.
                term: '',               // Termino de Busqueda.
            }
        },

        mounted() {
            console.log('Listado de Origenes Cargado.')
            this.cargarListado();
        
        }, // Mounted.

        computed: {

            /* Filtro del Listado, por Apellido y Nombre. */

            arrayFilter: function(){
              return this.listElements.filter(
                (element) => element.name.toLowerCase().includes(this.term.toLowerCase())
                || element.misc_name.toLowerCase().includes(this.term.toLowerCase())
              )
            }

        }, // Computed.


        methods: {
            
            /* Carga el listado inicial desde la db.  */
            cargarListado: function(){
                axios
                .get('origin')
                .then(listado => {
                    var countObj = Object.keys(listado.data).length;
                    if (countObj > 0) {
                        this.success = true;
                        for (var i = 0; i < countObj; i++) {
                            this.listElements.push(listado.data[i]);
                        }
                    }
                })
            },

            /* Carga en la vista un nuevo elemento y lo muestra. */

            pushData(data){
              this.listElements.push(data);
              this.success = true;
              this.operation = 0;
            },

            /* Establece la vista segun se indique. */

            clearView(param){
              this.dataReg = [];
              this.operation = param;

            },

        }, // Methods.

    }
</script>
