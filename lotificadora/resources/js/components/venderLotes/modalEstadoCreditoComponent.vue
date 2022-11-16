<template>
    
        <div class="modal fade" id="modalEsatdoCredito" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-book"></i> Estado de Credito</h5>
                        <button type="button" class="close" v-on:click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                        <div class="row" v-for="(resumen) in estadoCreditoDatos.resumenVenta">
                                <div class="col-md-7">
                                     <div class="form-group">
                                        <h2><label>Cliente:</label></h2>
                                        <h3> {{resumen.primer_nombre}} {{resumen.segundo_nombre}} {{resumen.primer_apellido}} {{resumen.segundo_apellido}} </h3>
                                        <h4>{{resumen.identidad}} - {{resumen.cel}}</h4>
                                        
                                    </div>
                               </div>
                               <div class="col-md-5">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h5 class="card-subtitle mb-2"><label>Resumen de Venta</label></h5>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <h6 class="card-subtitle mb-2"><button type="button" class="btn btn-outline-info btn-sm float-right align-self-stretch" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver mas" v-on:click="resumenVenta(estadoCreditoDatos.idVenta)"><i class="fas fa-eye"></i></button></h6>
                                                    </div>
                                                </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6><p class="card-text">
                                                                <label>Prima:</label> L. {{resumen.prima}}
                                                            </p></h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><p class="card-text">
                                                                <label>Cuota:</label> L. {{resumen.cuota_mensual}}
                                                            </p></h6>
                                                        </div>
                                                    </div>
                                                     <div class="row">
                                                        <div class="col-md-6">
                                                            <h6><p class="card-text">
                                                                <label>Financiamiento:</label> {{resumen.anios_financiamiento}} años
                                                            </p></h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6><p class="card-text">
                                                                <label>Total:</label> L. {{resumen.total_pagar}}
                                                            </p></h6>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                </div>
                        </div>
                        <hr>
                        <template v-if="alerta == 1">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>¡Advertencia!</strong> Abono mayor a deuda o mal escrito.
                            <button type="button" class="close" v-on:click="quitarAlerta()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        </template>
                        <template v-else-if="estadoCreditoDatos.totalRestante == 0.00">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <center><strong><h2>¡Deuda Cancelada!</h2></strong></center>
                            </div>
                        </template>
                        <template v-else>
                        </template>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h3><label>Cuotas:</label></h3>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="sr-only float-right align-self-stretch" for="inlineFormInputGroupUsername2">Abonos</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <template v-if="estadoCreditoDatos.totalRestante == 0.00">
                                                    <input type="number" v-model="abono" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Abonar" disabled>
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text btn btn-sm btn-secondary" disabled><i class="fa fa-adjust"></i></button>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <input type="number" v-model="abono" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Abonar">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="input-group-text btn btn-sm btn-secondary" v-on:click="ejecutarAbono(estadoCreditoDatos.idVenta)"><i class="fa fa-adjust"></i></button>
                                                    </div>
                                                </template>
                                            </div>
                                            
                                        </div>
                                       
                                        <div class="col-md-3">
                                            <h3 class="text-danger float-right align-self-stretch"><i class="fa fa-arrow-down"> </i> <label> L. {{estadoCreditoDatos.totalRestante}}</label></h3>
                                        </div>
                                        <div class="col-md-3">
                                            <h3 class="text-primary float-right align-self-stretch"><i class="fa fa-arrow-up"> </i> <label>L. {{estadoCreditoDatos.pagos}}</label></h3>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-striped">
                                        <table class="table table-striped table-bordered" style="width:100%" id="letras">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha Cobro</td>
                                                    <td class="text-center">Cobro Sugerido</td>
                                                    <td class="text-center">Fecha Pago</td>
                                                    <td class="text-center">Monto Pago</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Cobrar</td>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(cobroMensual,i) in estadoCreditoDatos.fechaCobros" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-center"> {{cobroMensual.fecha_cobro}} </td>
                                                    <td class="text-center"> L. {{cobroMensual.cuota_mensual}}  </td>
                                                    <td class="text-center"> 
                                                        <template v-if="cobroMensual.fecha_pago == null">Sin datos</template>
                                                        <template v-else>{{cobroMensual.fecha_pago}}</template> 
                                                    </td>
                                                    <td class="text-center"> 
                                                        <template v-if="cobroMensual.cantidad_pago == null">Sin datos</template>
                                                        <template v-else>L. {{cobroMensual.cantidad_pago}}</template>
                                                    </td>
                                                    <td class="text-center"> 
                                                        <template v-if="cobroMensual.estadoFC == 'Pendiente'">
                                                            <span class="badge badge-info">{{cobroMensual.estadoFC}}</span>
                                                        </template>
                                                        <template v-else-if="cobroMensual.estadoFC == 'Cola'">
                                                            <span class="badge badge-primary">{{cobroMensual.estadoFC}}</span>
                                                        </template>
                                                        <template v-else-if="cobroMensual.estadoFC == 'Atrasado'">
                                                            <span class="badge badge-danger"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>  {{cobroMensual.estadoFC}}</span>
                                                        </template>
                                                        <template v-else-if="cobroMensual.estadoFC == 'Dia de cobro'">
                                                            <span class="badge badge-warning"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  {{cobroMensual.estadoFC}}</span>
                                                        </template>
                                                        <template v-else>
                                                            <span class="badge badge-success">{{cobroMensual.estadoFC}}</span>
                                                        </template>
                                                    </td>
                                                    <td class="text-center"> 
                                                               
                                                        <template v-if="cobroMensual.estadoFC == 'Cola'">
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    <button type="button" class="btn btn-sm btn-primary" v-on:click="cancelarCola(cobroMensual.idFC)"><i class="fa fa-reply"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-success" v-on:click="ejecutarCola(cobroMensual.idFC)"><i class="fa fa-plus"></i></button>
                                                                </div>
                                                        </template>
                                                        <template v-else>
                                                            <template v-if="estadoCreditoDatos.letraActiva == cobroMensual.idFC">
                                                                <button type="button" class="btn btn-sm btn-success" v-on:click="ejecutarPago(cobroMensual.idFC)"><i class="fa fa-plus"></i></button>
                                                            </template>
                                                            <template v-else-if="estadoCreditoDatos.ultimopago == cobroMensual.idFC">
                                                                <button type="button" class="btn btn-sm btn-primary" v-on:click="cancelarPago(cobroMensual.idFC)"><i class="fa fa-reply"></i></button>
                                                            </template>
                                                            <template v-else-if="cobroMensual.estadoFC == 'Pagado'">
                                                                <button type="button" class="btn btn-sm btn-light" disabled><i class="fa fa-reply"></i></button>
                                                            </template>
                                                            <template v-else-if="cobroMensual.estadoFC == 'Pendiente' || cobroMensual.estadoFC == 'Atrasado' || cobroMensual.estadoFC == 'Dia de cobro'">
                                                                <button type="button" class="btn btn-sm btn-light" disabled><i class="fa fa-plus"></i></button>
                                                            </template>
                                                        </template>
                                                    </td>
                                                                      
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal()">Cerrar</button>
                        <!--<template v-if="cliente == '' || informacionLote == 0">
                            <button type="button" class="btn btn-primary btn-sm" disabled>Realizar Venta</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-primary btn-sm" v-on:click="ejecutarVenta()">Realizar Venta</button>
                        </template> -->
                    </div>
                </div>
            </div>
            <modal-resumen-venta-component :resumenDeVenta="resumenDeVenta"></modal-resumen-venta-component>
        </div>
    
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    props:["estadoCreditoDatos"],
    data(){
        return{
            nombre:"",
            nBloques:"",
            descripcion:"",
            imagen:'',
            imagenMiniatura:'',
            dias:1,
            clientes:[],
            informacionLote:[],
            tiempo:"",
            prima:0,
            dias:30,
            interes:4,
            cliente:"",
            lotesFinanciados:[],
            creditoContado:0,
            accionCreditoContado:"",
            abono:"",
            alerta:0,
            resumenDeVenta:[]

        }
    },
    mounted(){
            axios.get('/clientes').then(respuesta=>{
                this.clientes = respuesta.data
                //console.log(respuesta.data)
            })
            
            axios.get('/venta/create').then(respuesta=>{
                console.log(respuesta.data)
                
            })

    },
    methods:{
        myTable(){
           $(function() {
               $('#letras').DataTable();
           });
       },
       myTableClear(){
           $("#letras").dataTable().fnDestroy();
       },
        cambioCreditoContado:function(){
            if(this.creditoContado == 1){
                this.creditoContado = 0
            }else{
                this.creditoContado = 1
            }
            
        },
        abrirModal:function(){
            axios.get('/lote_financiado').then(respuesta=>{
                this.lotesFinanciados = respuesta.data
                //console.log(respuesta.data)
                })

            $("#modalElegirLote").modal("show")
        },
        actualizarTabla:function(){
            axios.get('/lote_financiado').then(respuesta=>{
                this.lotesFinanciados = respuesta.data
                //console.log("lotes financiados")
               // console.log(respuesta.data)
            })
        },
        obtenerImagen(e){
            let file = e.target.files[0];
            this.imagen = file;
            this.cargarImagen(file);
            console.log(file);
        },

        cargarImagen(file){
            let reader = new FileReader();

            reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
            }
            reader.readAsDataURL(file);
        },
                agregarResidencial:function(){

            let formData = new FormData();
                    formData.append('nombre',this.nombre);
                    formData.append('nBloques',this.nBloques);
                    formData.append('descripcion',this.descripcion);
                    formData.append('imagen',this.imagen);

            axios.post('residenciales', formData).then(respuesta => {
                console.log(respuesta.data);
                this.nombre = "",
                this.nBloques = "",
                this.descripcion = "",
                this.imagen = "",
                this.imagenMiniatura = ""
                this.$emit("agregarResidencial")
                $("#modalRegistrarResidencial").trigger('click')
            })
 
             

            // $("#modalRegistrarResidencial").trigger('click')
           
        },
        cambioPrimaTiempo:function(){
            var data={
                "prima":this.prima,
                "tiempo":this.informacionLote.tiempo,
                "interes":this.interes/100
            }
            axios.post('/lotes/apoyo/II', data).then(respuesta => {
                //console.log(respuesta.data);
                this.informacionLote = respuesta.data[0]
            })
        },
        infoLotes:function(){
            axios.get("/lotes/apoyo/II/create").then(respuesta =>{
                this.informacionLote = respuesta.data[0]
                //console.log(respuesta.data[0])
            })
            //this.loteFinanciado()
            //this.actualizarTabla()
        },
        ejecutarPago:function(id){
            axios.get('/venta/'+id+'/edit').then(respuesta => {
                this.myTableClear()
                this.estadoCreditoDatos = respuesta.data[0]
                this.myTable();
               // this.$emit("actualizarVentas")
               // $("#modalLotesVeder").trigger('click')
            })
            
        },
        quitarAlerta:function(){
            this.alerta = 0
        },
        ejecutarAbono:function(){
            if(this.abono <= this.estadoCreditoDatos.deuda && this.abono[0] != "-" && this.abono != ""){
                this.alerta = 0;
                let formData = new FormData();
                        formData.append('abono',this.abono);
                        formData.append('id_venta',this.estadoCreditoDatos.idVenta);

                axios.post('venta/apoyo', formData).then(respuesta => {
                    this.abono = ""
                    //this.$emit("agregarResidencial")
                    this.estadoCreditoDatos = respuesta.data[0]
                    console.log(respuesta.data)
                })
            }else{
                this.alerta = 1;
            }
        },
        cancelarPago:function(id){
            axios.delete('/venta/'+id).then(respuesta => {
                this.myTableClear()
                this.estadoCreditoDatos = respuesta.data[0]
                this.myTable();
            })
            
        },
        cancelarCola:function(id){
            axios.get('/venta/apoyo/'+id).then(respuesta => {
                this.myTableClear()
                this.estadoCreditoDatos = respuesta.data[0]
                this.myTable();
            })
            
        },
        ejecutarCola:function(id){
            axios.get('/venta/apoyo/'+id+'/edit').then(respuesta => {
                this.myTableClear()
                this.estadoCreditoDatos = respuesta.data[0]
                this.myTable();
            })
            
        },
        cerrarModal:function(){
            this.$emit("actualizarVentas")
            $("#modalEsatdoCredito").modal("hide")
            //$("#modalEsatdoCredito").trigger('click')
        },
        resumenVenta:function(id){
            axios.get('/lotes/apoyo/II/'+id+'/edit').then(respuesta => {
            console.log(respuesta.data[0])
            this.resumenDeVenta = respuesta.data[0]
            $("#resumenVenta").modal("show")
            //$("#modalEsatdoCredito").trigger('click')
            })

        }
    },
    computed:{
        img(){
            return this.imagenMiniatura;
        }
    }
    
}
</script>