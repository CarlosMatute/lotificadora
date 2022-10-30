<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card elevation-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-tags fa-4x" style=" width:600; height:600;"></i>   
                            </div>
                            <div class="col-md-8">
                                <h4 class=""><b>Vender Lotes</b></h4>
                                <p class="text-muted">En este modulo puede registrar y administrar todas las ventas.</p>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group dropleft float-right align-self-stretch">                                        
                                    <button data-toggle="modal" v-on:click="registrarVenta" class="btn btn-sm btn-primary float-right align-self-stretch">Registrar Venta</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="class-row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pagando-tab" data-toggle="tab" href="#pagando" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-clock"></i> Pendiente</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="credito-tab" data-toggle="tab" href="#credito" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-credit-card"></i> Credito</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contado-tab" data-toggle="tab" href="#contado" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-handshake"></i> Contado</a>
            </li>
        </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pagando" role="tabpanel" aria-labelledby="pagando-tab">
                
                <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-striped">
                                        <table class="table table-striped table-bordered" style="width:100%" id="ventasPendientes">
                                            <thead class="bg-warning">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha</td>
                                                    <td class="text-left">Cliente</td>
                                                    <td class="text-center">Pago</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Estado Credito</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(venta,i) in ventas.pendiente" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-center">{{venta.fechaV}} </td>
                                                    <td class="text-left">{{venta.primer_nombre}} {{venta.segundo_nombre}} {{venta.primer_apellido}} {{venta.segundo_apellido}}</td>
                                                    <td class="text-center">{{venta.pago}} </td>
                                                    <td class="text-center">{{venta.estado}} </td>
                                                    <td class="text-center"> <button type="button" class="btn btn-sm btn-light" v-on:click="estadoCredito(venta.idV)"><i class="fa fa-book"></i></button> </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-warning">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha</td>
                                                    <td class="text-left">Cliente</td>
                                                    <td class="text-center">Pago</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Estado Credito</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                               </div>
                </div>

            </div>
            <div class="tab-pane fade" id="credito" role="tabpanel" aria-labelledby="credito-tab">
                <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-striped">
                                        <table class="table table-striped table-bordered" style="width:100%" id="ventasCredito">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha</td>
                                                    <td class="text-center">Cliente</td>
                                                    <td class="text-center">Pago</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Detalle Credito</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(venta,i) in ventas.credito" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-left">{{venta.fechaV}} </td>
                                                    <td class="text-left">{{venta.primer_nombre}} {{venta.segundo_nombre}} {{venta.primer_apellido}} {{venta.segundo_apellido}}</td>
                                                    <td class="text-center">{{venta.pago}} </td>
                                                    <td class="text-center">{{venta.estado}} </td>
                                                    <td class="text-center"> <button type="button" class="btn btn-sm btn-light" v-on:click="estadoCredito(venta.idV)"><i class="fa fa-book"></i></button> </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-primary">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha</td>
                                                    <td class="text-center">Cliente</td>
                                                    <td class="text-center">Pago</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Detalle Credito</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                               </div>
                </div>
            </div>
            <div class="tab-pane fade" id="contado" role="tabpanel" aria-labelledby="contado-tab">
                <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-striped">
                                        <table class="table table-striped table-bordered" style="width:100%" id="ventasContado">
                                            <thead class="bg-success">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha</td>
                                                    <td class="text-center">Cliente</td>
                                                    <td class="text-center">Pago</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Detalle Venta</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(venta,i) in ventas.contado" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-left">{{venta.fechaV}} </td>
                                                    <td class="text-left">{{venta.primer_nombre}} {{venta.segundo_nombre}} {{venta.primer_apellido}} {{venta.segundo_apellido}}</td>
                                                    <td class="text-center">{{venta.pago}} </td>
                                                    <td class="text-center">{{venta.estado}} </td>
                                                    <td class="text-center"> <button type="button" class="btn btn-sm btn-light" v-on:click="resumenVenta(venta.idV)"><i class="fa fa-book"></i></button> </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-success">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha</td>
                                                    <td class="text-center">Cliente</td>
                                                    <td class="text-center">Pago</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Detalle Venta</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                               </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <modal-registrar-venta-component></modal-registrar-venta-component>
        <modal-expediente-cliente-component :verInfoCliente="verInfoCliente" @actualizarClientes="actualizarClientes"></modal-expediente-cliente-component>
        <modal-lotes-vender-component @actualizarVentas="actualizarVentas"></modal-lotes-vender-component>
        <modal-estado-credito-component :estadoCreditoDatos="estadoCreditoDatos" @actualizarVentas="actualizarVentas"></modal-estado-credito-component>
        <modal-resumen-venta-contado-component :resumenDeVenta="resumenDeVenta"></modal-resumen-venta-contado-component>
        <!--<modal-bloques-component @actualizarResidenciales="actualizarResidenciales"></modal-bloques-component>-->
    </div>
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    data(){
        return{
            ventas:[],
            verInfoCliente:[],
            estadoCreditoDatos:[],
            resumenDeVenta:[]
        }
    },
    mounted(){
            axios.get('/venta').then(respuesta=>{
                this.ventas = respuesta.data[0]
                this.myTable()
            })

    },
    methods:{
        myTable(){
           $(function() {
               $('#ventasPendientes').DataTable();
               $('#ventasCredito').DataTable();
               $('#ventasContado').DataTable();
           });
       },
       myTableClear(){
           $("#ventasPendientes").dataTable().fnDestroy();
           $("#ventasCredito").dataTable().fnDestroy();
           $("#ventasContado").dataTable().fnDestroy();
       },
        actualizarVentas:function(){
            axios.get('/venta').then(respuesta=>{
                this.myTableClear()
                this.ventas = respuesta.data[0]
                this.myTable()
            })
        },
        registrarVenta:function(){
                axios.get('/lote_financiado/create').then(respuesta=>{
                //this.lotesFinanciados = respuesta.data
                //console.log("lotes borrados")
                //console.log(respuesta.data)
                $("#modalLotesVeder").modal("show")
            })
        },
        estadoCredito:function(id){
           axios.get("/venta/"+id).then(respuesta=>{
                this.estadoCreditoDatos = respuesta.data[0]
                $("#modalEsatdoCredito").modal("show")
                console.log(respuesta.data[0])
                $(function() {
                $('#letras').DataTable();
                });
            })
         
           },
        bloques:function(idR){
            axios.get("residenciales/"+idR).then(respuesta=>{
                this.verBloques=respuesta.data
                //console.log('ver residenciales')
                //console.log(respuesta.data)
                $("#modalBloques").modal("show")
                })
        },
        actualizarClientes:function(){
           axios.get('/clientes').then(respuesta=>{
                this.myTableClear()
                this.clientes = respuesta.data
                this.myTable()
            })
        },
        resumenVenta:function(id){
            axios.get('/lotes/apoyo/II/'+id+'/edit').then(respuesta => {
            console.log(respuesta.data[0])
            this.resumenDeVenta = respuesta.data[0]
            $("#resumenVentaContado").modal("show")
            //$("#modalEsatdoCredito").trigger('click')
            })

        }
    }
    
}
</script>