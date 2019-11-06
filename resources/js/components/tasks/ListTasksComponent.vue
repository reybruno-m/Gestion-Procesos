<template>
    <div>
        <!-- Accion Nueva Tarea -->
        <div class="row">
            <div class="col text-left">
                <button 
                    class="btn btn-sm btn-dark" 
                    @click="setView(1)" 
                    id="nueva_solicitud"
                    >NUEVA TAREA</button>
            </div>
        </div>

        <br><br>

        <!-- Inicio Encabezado, Filtros -->
        <div class="row" v-if="operation == 0">
            <div class="col-lg-11 col-md-11 text-left">
                <input 
                    type="text" 
                    class="form-control" 
                    name="filtro" 
                    id="filtro" 
                    placeholder="Filtrar Peticiones" 
                    autofocus="" 
                    autocomplete="off" 
                    v-model="termKey"
                >
            </div>

            <div class="col-lg-1 col-md-1 text-left">
                <div class="btn-group">
                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    PRIORIDAD
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" @click="setPriority('todo')" href="#">
                            Todos
                        </a>
                        <a class="dropdown-item" @click="setPriority('baja')" href="#">
                            Baja
                            <i class="fa fa-circle icon-prio Baja"></i>
                        </a>
                        <a class="dropdown-item" @click="setPriority('intermedia')" href="#">
                            Intermedia
                            <i class="fa fa-circle icon-prio Intermedia"></i>
                        </a>
                        <a class="dropdown-item" @click="setPriority('alta')" href="#">
                            Alta
                            <i class="fa fa-circle icon-prio Alta"></i>
                        </a> 
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Fin Encabezado, Filtros -->

        <div class="row" v-if="textFilter != ''">
            <br>
            <div class="col">
                <div class="alert" v-bind:class="classAlert" role="alert">
                  Mostrando Resultados con prioridad <b>{{ textFilter }}</b>
                </div>
            </div>
        </div>

        <br>

        <!-- Inicio Formulario -->

        <div class="row">
            <form-tasks-component 
                :registry = 'dataReg'
                :operation = this.operation
                v-if="this.operation > 0"
                @clearView="clearView"
                @pushData="pushData"
            ></form-tasks-component>
        </div>

        <!-- FIN, Formulario -->

        <!-- Inicio Cuerpo, Peticiones -->
        
        <div class="row sep" v-for="(e, index) in tasksFilter" :key="e.id">
            <div class="col">
                <div class="card">
                    <div class="card-header" v-bind:class="e.misc.name">
                        <i class="fa fa-circle"></i>
                        <b>Destino:</b> {{ e.destinity.name }}</i>
                        <span class="time-create">
                            {{ e.created_at | formatDate }}
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="card-body">
                        <p>{{ e.description }}</p> <!-- e.movements[0].taken -->
                        
                        <footer class="blockquote-footer">
                            Creada por {{e.user.last_name +" "+ e.user.first_name +" ("+ e.origin.name +")" }}
                        </footer>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-left">
                                
                                <router-link 
                                    class="link" 
                                    :to="{ name: 'detalle-tarea', params:{ id: e.id } }"
                                    >
                                    <button class="btn btn-sm btn-secondary">
                                        DETALLES
                                    </button>
                                </router-link>   

                                <input 
                                    type="button" 
                                    v-if="
                                        e.destinity_id == origin_id ||
                                        e.movements[e.movements.length -1].finalized != null    
                                    " 
                                    class="btn btn-sm btn-primary" 
                                    @click="takeTask(e, index)" 
                                    value="TOMAR"
                                >
                                
                            </div>
                            <div class="col text-right">
                                <span 
                                    v-if="
                                        e.user_id == user_login &&
                                        e.movements.length == 1
                                    "
                                    class="badge badge-pill badge-danger"
                                    @click="deleteTask(e, index)"
                                >ELIMINAR</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="!success && this.operation == 0">
            <div class="col">
                <h5 class="text-center"><i>No se encontraron Peticiones para Mostrar!</i></h5>
            </div>
        </div>

        <!-- Fin Cuerpo, Peticiones -->
    </div>
</template>
 
<script>
    export default {
        data()
        {
            return {
                success: false,                 // true <- muestra listado | false <- muestra mjs sin resultados.
                operation: 0,                   // 0 listado, 1 alta, 2 edita.
                dataReg: [],                    // Datos del origen nuevo/edicion. 'registry', 
                listTasks: [],                  // Listado de Tareas.
                priorityKey: 'todo',            // Metodo a llamar para filtrado.
                termKey: '',                    // termino de filtrado.
                textFilter: '',                 // Texto del Dropdown de filtrado.
                classAlert: 'alert-primary',    // Modifica la Clase del alert de filtrado.
                user_login: "",                 // Almacena el ID del usuario de sesion activa.
                origin_id: "",                  // Almacena el origin_id del usuario de sesion activa.
                movemets_modal: [],             // Listado de movimientos que se cargaran en el modal.
                current_task: '',               // Almacena el Indice de la tarea cargada en el modal.
                listStates: [],                 // Listado de estados posibles para la carga de un movimiento.
                movement_data: [],              // Contiene los datos para la nueva carga de un movimiento

            }
        },

        mounted() 
        {  
            this.loadList();
            this.getStates();
        }, // Mounted.

        computed: 
        {
            tasksFilter() {
                if (this.listTasks.length > 0) 
                { 
                    let result = this[this.priorityKey];
                    const term = this.termKey.toLowerCase()
                    const filter = event => 
                        event.origin.name.toLowerCase().includes(term) || 
                        event.description.toLowerCase().includes(term) ||
                        event.user.last_name.toLowerCase().includes(term) ||
                        event.user.first_name.toLowerCase().includes(term)

                    return result.filter(filter) 
                }
            },

            todo() {
              return this.listTasks
            },

            baja() {
                let result = this.listTasks
                const filter = event => event.misc.name.toLowerCase().includes('baja')
                return result.filter(filter)
            },

            intermedia() {
                let result = this.listTasks
                const filter = event => event.misc.name.toLowerCase().includes('intermedia')
                return result.filter(filter)
            },

            alta() {
                let result = this.listTasks
                const filter = event => event.misc.name.toLowerCase().includes('alta')
                return result.filter(filter)
            }
        }, // Computed.

		methods: 
        {
            // Establece la vista segun se indique.
            setView(val){
              this.dataReg = [];
              this.operation = val;
            },

            // Establece la vista segun se indique.
            clearView(param){
              this.dataReg = [];
              this.operation = param;
            },
            
            // Carga el listado inicial desde la db. 
            loadList: function(){
                axios
                .get('api/task')
                .then(listado => {
                    var countObj = Object.keys(listado.data.tasks).length;
                    if (countObj > 0) {
                        this.success = true;
                        for (var i = 0; i < countObj; i++) {
                            // Arreglo con listado de tareas.
                            this.listTasks.push(listado.data.tasks[i]);
                            this.user_login = listado.data.user_id;         
                            this.origin_id = listado.data.origin_id;         
                        }
                    }
                })
            },

            deleteTask(data, index){
                if (confirm("Proceder y eliminar la Tarea seleccionada?, la misma dejara de estar disponible.")) {
                    axios
                    .delete('api/task/' + data.id)
                    .then(response => {
                        if (response.data.success) {
                            this.listTasks.splice(index, 1);
                            alert(response.data.msj);
                        }else{
                            alert(response.data.errors[0]);
                        }
                    })
                    .catch(error => console.log(error))
                }
            },

            takeTask(data, index){
                if (confirm("Desea Tomar la Tarea seleccionada?")) {
                    let params = new FormData();
                    params.append("id", data.id);
                    
                    axios
                    .post('api/addMovement', params)
                    .then(response => {
                        if (response.data.success) {
                            alert("Tarea tomada con exito.");
                            this.listTasks[index].movements.push(response.data.elements);
                        }else{
                            alert(response.data.errors[0]);
                        }
                    })
                    .catch(error => console.log(error))
                } 
            },

            getStates(){
                axios
                .get('api/getStates')
                .then(listado => {
                    var countObj = Object.keys(listado.data).length;
                    if (countObj > 0) {
                        for (var i = 0; i < countObj; i++) {
                            this.listStates.push(listado.data[i]);
                        }
                    }
                })
            },

            // Carga en la vista un nuevo elemento y lo muestra.
            pushData(data){
              this.listTasks.push(data);
              this.success = true;
              this.operation = 0;
              document.getElementById('nueva_solicitud').focus();
            },

            // Modifica, Muestra y Oculta los alerts que indican los filtros aplicados.
            changeTextFitler: function(prio){
                switch(prio){
                    case 'baja': 
                        this.textFilter = 'Baja'; 
                        this.classAlert = 'alert-baja';
                        break;
                    case 'intermedia': 
                        this.textFilter = 'Intermedia'; 
                        this.classAlert = 'alert-intermedia';
                        break;
                    case 'alta': 
                        this.textFilter = 'Alta.'; 
                        this.classAlert = 'alert-alta';
                        break;
                    default: 
                        this.textFilter = ''; 
                        this.classAlert = '';
                        this.termKey = '';
                        document.getElementById('filtro').focus();
                        break;
                }
            },

            // Se utiliza para llamar 2 Metodos desde un solo @click.
            setPriority: function(prio){
                this.priorityKey = prio     // Modifica los datos filtrados, llama el metodo que dice 'prio'
                this.changeTextFitler(prio) // Modifica el Alert que indica los resultados mostrados.
            },
        },

    }
</script> 

<style type="text/css">
    .sep{
        margin-bottom: 15px;
    }
    .title-origen{
        color: #3C8DBC;
    }
    .time-create{
        float: right;
        color: #656565;
        padding: 3px 0px 0px 0px;
        font-size: 14px;

    }
    .small-item{
        font-size: 13px;
    }
    .card-footer{
        height: 50px !important;
    }
    .icon-prio{
        width: 10px;
        height: 10px;
        float: right;
        margin-top: 8px;
    }

    /* Timeline holder */
    ul.timeline {
        list-style-type: none;
        position: relative;
        padding-left: 1.5rem;
    }

     /* Timeline vertical line */
    ul.timeline:before {
        content: ' ';
        background: #fff;
        display: inline-block;
        position: absolute;
        left: 16px;
        width: 4px;
        height: 100%;
        z-index: 400;
        border-radius: 1rem;
    }

    li.timeline-item {
        margin: 20px 0;
    }

    /* Timeline item arrow */
    .timeline-arrow {
        border-top: 0.5rem solid transparent;
        border-right: 0.5rem solid #fff;
        border-bottom: 0.5rem solid transparent;
        display: block;
        position: absolute;
        left: 2rem;
    }

    /* Timeline item circle marker */
    li.timeline-item::before {
        content: ' ';
        background: #ddd;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #fff;
        left: 11px;
        width: 14px;
        height: 14px;
        z-index: 400;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .time-scroll{
        max-height: 350px; 
        overflow-x: hidden;
    }
</style>
