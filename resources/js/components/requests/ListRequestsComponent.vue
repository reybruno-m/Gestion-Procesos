 <template>
    <div class="container-fluid">
       
        <div class="row">
            <form-requests-component></form-requests-component>
        </div>

        <br>

        <!-- Inicio Encabezado, Filtros -->

        <br>
        
        <div class="row separator">
            <div class="col text-left">
                <input 
                    type="text" 
                    class="form-control" 
                    name="filtro" 
                    placeholder="Filtrar Solicitudes" 
                    autofocus="" 
                    autocomplete="off" 
                    v-model="termKey"
                >
                
            </div>
            <div class="col-6 text-left">
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
                            <i class="fa fa-circle icon-prio baja"></i>
                        </a>
                        <a class="dropdown-item" @click="setPriority('intermedia')" href="#">
                            Intermedia
                            <i class="fa fa-circle icon-prio intermedia"></i>
                        </a>
                        <a class="dropdown-item" @click="setPriority('alta')" href="#">
                            Alta
                            <i class="fa fa-circle icon-prio alta"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col text-right">
                <button class="btn btn-success">
                    <i class="fa fa-plus-square" aria-hiden="true"></i>
                     NUEVA
                </button>
            </div>
        </div>
        
        <!-- Fin Encabezado, Filtros -->

        <br>

        <div class="row separator" v-if="textFilter != ''">
            <div class="col">
                <div class="alert" v-bind:class="classAlert" role="alert">
                  Mostrando Resultados con prioridad <b>{{ textFilter }}</b>
                </div>
            </div>
        </div>

        <br>

        <!-- Inicio Cuerpo, Peticiones -->

        <div class="row separator" v-for="(element, index) in requestFilter" :key="element.id" v-if="success">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-circle"></i>
                        <i class="title-origen"><b>{{element.origen}}</b></i>
                        <span class="time-create">
                            {{ element.created_at | formatDate }}
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="card-body">
                        <p>{{ element.description }}</p>
                        <footer class="blockquote-footer">Creada por {{element.last_name +" "+ element.first_name}}</footer>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-left">
                                <input type="button" class="btn btn-sm btn-primary" value="TOMAR">
                                <input type="button" class="btn btn-sm btn-secondary" value="ASIGNAR">
                            </div>
                            <div class="col text-right" hidden="">
                                <span class="badge badge-pill badge-success">
                                    3 Archivos 
                                    <i class="fa fa-paperclip" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row separator" v-else>
            <h5 class="text-center">Sin resultados para mostrar.</h5>
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
                listRequests: [],               // Listado de Requests.
                priorityKey: 'todo',            // Metodo a llamar para filtrado.
                termKey: '',                    // termino de filtrado.
                textFilter: '',                 // Texto del Dropdown de filtrado.
                classAlert: 'alert-primary',    // Modifica la Clase del alert de filtrado.
            }
        },

        mounted() 
        {  
            this.loadList();

        }, // Mounted.

        computed: 
        {
            requestFilter() {
                let result = this[this.priorityKey];
                const term = this.termKey.toLowerCase()
                const filter = event => 
                    event.origen.toLowerCase().includes(term) || 
                    event.description.toLowerCase().includes(term) ||
                    event.last_name.toLowerCase().includes(term) ||
                    event.first_name.toLowerCase().includes(term)
                
                return result.filter(filter)
            },

            todo() {
              return this.listRequests
            },

            baja() {
                let result = this.listRequests
                const filter = event => event.prioridad.toLowerCase().includes('baja')
                return result.filter(filter)
            },

            intermedia() {
                let result = this.listRequests
                const filter = event => event.prioridad.toLowerCase().includes('intermedia')
                return result.filter(filter)
            },

            alta() {
                let result = this.listRequests
                const filter = event => event.prioridad.toLowerCase().includes('alta')
                return result.filter(filter)
            }
        }, // Computed.

		methods: 
        {
            // Carga el listado inicial desde la db. 
            loadList: function(){
                axios
                .get('request')
                .then(listado => {
                    var countObj = Object.keys(listado.data).length;
                    if (countObj > 0) {
                        this.success = true;
                        for (var i = 0; i < countObj; i++) {
                            this.listRequests.push(listado.data[i]);
                        }
                    }
                })
            },

            // Modifica, Muestra y Oculta los alerts que indican los filtros aplicados.
            changeTextFitler: function(prio){
                switch(prio){
                    case 'baja': 
                        this.textFilter = 'Baja'; 
                        this.classAlert = 'alert-primary';
                        break;
                    case 'intermedia': 
                        this.textFilter = 'Intermedia'; 
                        this.classAlert = 'alert-warning';
                        break;
                    case 'alta': 
                        this.textFilter = 'Alta.'; 
                        this.classAlert = 'alert-danger';
                        break;
                    default: 
                        this.textFilter = ''; 
                        this.classAlert = '';
                        this.termKey = '';
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
    .separator{
        margin: 10px 0px 10px 0px;
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
        float: right;
        padding-top: 4px;
    }

    .baja{ color: #CCE5FF; }
    .intermedia{ color: #F39C12; }
    .alta{ color: #F56954; }
</style>
