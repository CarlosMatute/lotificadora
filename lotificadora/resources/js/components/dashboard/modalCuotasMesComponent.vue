<template>
    
        <div class="modal fade" id="modalCuotasMes" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-list-ul"></i>
                         Cuotas de 
                         <template v-if="cuotasMes.id == 1">Enero</template>
                         <template v-if="cuotasMes.id == 2">Febrero</template>
                         <template v-if="cuotasMes.id == 3">Marzo</template>
                         <template v-if="cuotasMes.id == 4">Abril</template>
                         <template v-if="cuotasMes.id == 5">Mayo</template>
                         <template v-if="cuotasMes.id == 6">Junio</template>
                         <template v-if="cuotasMes.id == 7">Julio</template>
                         <template v-if="cuotasMes.id == 8">Agosto</template>
                         <template v-if="cuotasMes.id == 9">Septiembre</template>
                         <template v-if="cuotasMes.id == 10">Octubre</template>
                         <template v-if="cuotasMes.id == 11">Noviembre</template>
                         <template v-if="cuotasMes.id == 12">Diciembre</template>
                          <!-- de {{cuotasMes.añoActual}} -->
                          
                         </h5>
                        <button type="button" class="close" v-on:click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-striped">
                                        <input type="hidden" v-model="cuotasMes.id">
                                        <table class="table table-striped table-bordered" style="width:100%" id="letrasMes">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Venta</td>
                                                    <td class="text-center">Cliente</td>
                                                    <td class="text-center">Telefono</td>
                                                    <td class="text-center">Fecha Cobro</td>
                                                    <td class="text-center">Cobro Sugerido</td>
                                                    <!-- <td class="text-center">Fecha Pago</td>
                                                    <td class="text-center">Monto Pago</td> -->
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Acciones</td>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(cuotas,i) in cuotasMes.infoCuotas" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-center"> {{cuotas.fechaV}} </td>
                                                    <td class="text-center"> {{cuotas.primer_nombre}} {{cuotas.primer_apellido}}</td>
                                                    <td class="text-center"> {{cuotas.cel}} </td>
                                                    <td class="text-center"> {{cuotas.fecha_cobro}} </td>
                                                    <td class="text-center"> L. {{cuotas.cuota_mensual}}  </td>
                                                    <!-- <td class="text-center"> 
                                                        <template v-if="cuotas.fecha_pago == null">Sin datos</template>
                                                        <template v-else>{{cuotas.fecha_pago}}</template> 
                                                    </td>
                                                    <td class="text-center"> 
                                                        <template v-if="cuotas.cantidad_pago == null">Sin datos</template>
                                                        <template v-else>L. {{cuotas.cantidad_pago}}</template>
                                                    </td> -->
                                                    <td class="text-center"> 
                                                        <template v-if="cuotas.estadoFC == 'Pendiente'">
                                                            <span class="badge badge-info">{{cuotas.estadoFC}}</span>
                                                        </template>
                                                        <template v-else-if="cuotas.estadoFC == 'Cola'">
                                                            <span class="badge badge-primary">{{cuotas.estadoFC}}</span>
                                                        </template>
                                                        <template v-else-if="cuotas.estadoFC == 'Atrasado'">
                                                            <span class="badge badge-danger"><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>  {{cuotas.estadoFC}}</span>
                                                        </template>
                                                        <template v-else-if="cuotas.estadoFC == 'Dia de cobro'">
                                                            <span class="badge badge-warning"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  {{cuotas.estadoFC}}</span>
                                                        </template>
                                                        <template v-else>
                                                            <span class="badge badge-success">{{cuotas.estadoFC}}</span>
                                                        </template>
                                                    </td>
                                                    <td class="text-center"> 
                                                               
                                                        <!--<template v-if="cuotas.estadoFC == 'Cola'">
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    <button type="button" class="btn btn-sm btn-primary" v-on:click="cancelarCola(cuotas.idFC)"><i class="fa fa-reply"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-success" v-on:click="ejecutarCola(cuotas.idFC)"><i class="fa fa-plus"></i></button>
                                                                </div>
                                                        </template>
                                                        <template v-else>
                                                            <template v-if="cuotas.letraActiva == cuotas.idFC">-->
                                                                <button type="button" class="btn btn-xs btn-secondary" v-on:click="estadoCredito(cuotas.idV)"><i class="fa fa-share"></i> Cobrar</button>
                                                                <button type="button" class="btn btn-xs btn-success" v-on:click="mensaje(cuotas.cel)"><i class="fa fa-envelope"></i> WhatsApp</button>
                                                            <!--</template>
                                                            <template v-else-if="cuotas.ultimopago == cuotas.idFC">
                                                                <button type="button" class="btn btn-sm btn-primary" v-on:click="cancelarPago(cuotas.idFC)"><i class="fa fa-reply"></i></button>
                                                            </template>
                                                            <template v-else-if="cuotas.estadoFC == 'Pagado'">
                                                                <button type="button" class="btn btn-sm btn-light" disabled><i class="fa fa-reply"></i></button>
                                                            </template>
                                                            <template v-else-if="cuotas.estadoFC == 'Pendiente' || cuotas.estadoFC == 'Atrasado' || cuotas.estadoFC == 'Dia de cobro'">
                                                                <button type="button" class="btn btn-sm btn-light" disabled><i class="fa fa-plus"></i></button>
                                                            </template>
                                                        </template>-->
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
            
            <modal-estado-credito-component :estadoCreditoDatos="estadoCreditoDatos" @actualizarVentas="actualizarVentas"></modal-estado-credito-component><!--@actualizarVentas="actualizarVentas"-->
        </div>
    
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    props:["cuotasMes"],
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
            resumenDeVenta:[],
            estadoCreditoDatos:[],
            mensaje_texto:""

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
               $('#letrasMes').DataTable();
           });
       },
       myTableClear(){
           $("#letrasMes").dataTable().fnDestroy();
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
        actualizarVentas:function(){
            axios.get("/dashboard/"+this.cuotasMes.id).then(respuesta=>{
                console.log(respuesta.data[0])
                this.myTableClear()
                this.cuotasMes = respuesta.data[0]
                this.myTable()
                //$("#modalCuotasMes").modal("show")
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
                this.estadoCreditoDatos = respuesta.data[0]
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
                this.estadoCreditoDatos = respuesta.data[0]
               // this.$emit("actualizarVentas")
               // $("#modalLotesVeder").trigger('click')
            })
            
        },
        cancelarCola:function(id){
            axios.get('/venta/apoyo/'+id).then(respuesta => {
                this.estadoCreditoDatos = respuesta.data[0]
               // this.$emit("actualizarVentas")
               // $("#modalLotesVeder").trigger('click')
            })
            
        },
        ejecutarCola:function(id){
            axios.get('/venta/apoyo/'+id+'/edit').then(respuesta => {
                this.estadoCreditoDatos = respuesta.data[0]
               // this.$emit("actualizarVentas")
               // $("#modalLotesVeder").trigger('click')
            })
            
        },
        cerrarModal:function(){
            this.$emit("actualizarEstados")
            $("#modalCuotasMes").modal("hide")
            //$("#modalEsatdoCredito").trigger('click')
        },
        resumenVenta:function(id){
            axios.get('/lotes/apoyo/II/'+id+'/edit').then(respuesta => {
            console.log(respuesta.data[0])
            this.resumenDeVenta = respuesta.data[0]
            $("#resumenVenta").modal("show")
            //$("#modalEsatdoCredito").trigger('click')
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

           mensaje:function(celular){
            this.mensaje_texto = "Estimado cliente, le saluda Inversiones Rivera Carvajal, el motivo de este mensaje "+
                                "es para hacerle saber que tiene moras Pendientes. Por favor ponerse al día. Gracias."
            window.open('https://api.whatsapp.com/send?phone=504'+celular+'&text='+this.mensaje_texto+'','_blank');
         
           },
    },
    computed:{
        img(){
            return this.imagenMiniatura;
        }
    }
    
}
</script>