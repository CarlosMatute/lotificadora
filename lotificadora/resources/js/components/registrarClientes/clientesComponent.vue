<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card elevation-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-user fa-4x" style=" width:600; height:600;"></i>   
                            </div>
                            <div class="col-md-8">
                                <h4 class=""><b>Clientes</b></h4>
                                <p class="text-muted">En este modulo puede registrar y administrar todos los clientes.</p>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group dropleft float-right align-self-stretch">                                        
                                    <button data-toggle="modal" data-target="#modalRegistrarCliente" class="btn btn-sm btn-primary float-right align-self-stretch">Registrar Cliente</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-striped">
                                        <table class="table table-sm responsive" style="width:100%" id="clientes">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-left">Nombre</td>
                                                    <td class="text-center">Identidad</td>
                                                    <td class="text-center">Telefono</td>
                                                    <td class="text-center">Expediente</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(cliente,i) in clientes" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-left">{{cliente.primer_nombre}} {{cliente.segundo_nombre}} {{cliente.primer_apellido}} {{cliente.segundo_apellido}}</td>
                                                    <td class="text-center">{{cliente.identidad}} </td>
                                                    <td class="text-center">{{cliente.cel}} </td>
                                                    <td class="text-center"> <button type="button" class="btn btn-sm btn-light" v-on:click="verExpediente(cliente.id)"><i class="fa fa-address-book"></i></button> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                               </div>
        </div>
        <modal-registrar-cliente-component @actualizarClientes="actualizarClientes"></modal-registrar-cliente-component>
        <modal-expediente-cliente-component :verInfoCliente="verInfoCliente" @actualizarClientes="actualizarClientes"></modal-expediente-cliente-component>
        <!--<modal-bloques-component @actualizarResidenciales="actualizarResidenciales"></modal-bloques-component>-->
    </div>
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    data(){
        return{
            clientes:[],
            verInfoCliente:[]
        }
    },
    mounted(){
            axios.get('/clientes').then(respuesta=>{
                this.clientes = respuesta.data
                this.myTable()
            })

    },
    methods:{
        myTable(){
           $(function() {
               $('#clientes').DataTable();
           });
       },
       myTableClear(){
           $("#clientes").dataTable().fnDestroy();
       },
        verExpediente:function(id){
            axios.get("/clientes/"+id).then(respuesta=>{
                this.verInfoCliente = respuesta.data[0]
                console.log(respuesta.data[0])
                $("#modalExpediente").modal("show")
            })
         
           },
        bloques:function(idR){
            axios.get("residenciales/"+idR).then(respuesta=>{
                this.verBloques=respuesta.data
                console.log('ver residenciales')
                console.log(respuesta.data)
                $("#modalBloques").modal("show")
                })
        },
        actualizarClientes:function(){
           axios.get('/clientes').then(respuesta=>{
                this.myTableClear()
                this.clientes = respuesta.data
                this.myTable()
            })
        }
    }
    
}
</script>