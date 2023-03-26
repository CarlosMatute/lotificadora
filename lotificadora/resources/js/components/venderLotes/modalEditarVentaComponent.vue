<template>
    
    <div class="modal fade" id="modalEditarVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Editar Venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                
                   
                    <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Cliente:</label>
                                    <input list="input_clientes" v-model="datosVenta.identidad" class="form-control border-dark" id="browser"  autocomplete="off">
                                    <datalist id="input_clientes">
                                        <option v-for="cliente in clientes" v-bind:value="cliente.identidad"> {{cliente.primer_nombre}} {{cliente.segundo_nombre}} {{cliente.primer_apellido}} {{cliente.segundo_apellido}}</option>
                                    </datalist>
                                </div>
                           </div>
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Agregar Lotes:</label> En desarrollo
                                            <div>
                                            <button type="button" class="btn btn-secondary btn-block" disabled v-on:click="abrirModal(datosVenta.id_venta)">Lotes</button>
                                            </div>
                                        </div>
                                </div>
                                <template v-if="this.datosVenta.pago == 'Credito'">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Contado/Credito:</label>
                                            <div>
                                            <button type="button" class="btn btn-primary btn-block" v-on:click="cambioCreditoContado()"><i class="fa fa-credit-card"></i></button>
                                            </div>
                                        </div>
                                </div>
                                </template>
                                <template v-else>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Contado/Credito:</label>
                                            <div>
                                            <button type="button" class="btn btn-success btn-block" v-on:click="cambioCreditoContado()"><i class="fa fa-handshake"></i></button>
                                            </div>
                                        </div>
                                </div>
                                </template>
                           
                    </div>
                    <hr>
                    <!--<input type="hidden" v-model="informacionLote.idLote">-->
                    <template v-if="this.datosVenta.pago == 'Credito'">
                        <h2><label>Credito</label></h2>
                        <div class="row">
                            <div class="col-md-3">
                                 <div class="form-group">
                                    <label>Prima:</label>
                                    <input type="number" v-model="datosVenta.prima" v-on:change="cambioPrimaTiempo" class="form-control border-dark">
                                </div>
                           </div>
                           <div class="col-md-2">
                                 <div class="form-group">
                                    <label>Tasa de interes anual:</label>
                                    <input type="number" v-model="datosVenta.tasa_interes" v-on:change="cambioPrimaTiempo" class="form-control border-dark">
                                </div>
                           </div>
                           <div class="col-md-3">
                                <div class="form-group">
                                    <label>Dias cobro al mes:</label>
                                    <div class="input-group">
                                        <input type="range" v-model="datosVenta.dias_cobro_mes" class="form-control" min="1" max="30">
                                        <div class="input-group-prepend">
                                            &nbsp;<button class="form-control form-group">{{datosVenta.dias_cobro_mes}}</button>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <div class="col-md-2">
                                <div class="form-group">
                                    <label>Años de financiamiento:</label>
                                    <div>
                                        <select v-model="datosVenta.anios_financiamiento" v-on:change="cambioPrimaTiempo" class="form-control border-dark">
                                            <option selected>--Elija un año--</option>
                                            <option v-bind:value="1">1 año</option>
                                            <option v-bind:value="2">2 años</option>
                                            <option v-bind:value="3">3 años</option>
                                            <option v-bind:value="4">4 años</option>
                                            <option v-bind:value="5">5 años</option>
                                            <option v-bind:value="6">6 años</option>
                                        </select>
                                    </div>
                                </div>
                           </div>   
                           <div class="col-md-2">
                                 <div class="form-group">
                                    <label>Cuota mensual:</label>
                                    <input type="number" v-model="datosVenta.cuota" v-on:change="formatearCuotaMensual" class="form-control border-dark">
                                </div>
                           </div>     
                        </div>
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-dark">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Total Contado:</label> L. {{datosVenta.contado_formato}}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Financiamiento:</label> {{datosVenta.anios_financiamiento}} años
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Tasa de interes anual:</label> {{datosVenta.tasa_interes}}%
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Prima:</label> L. {{datosVenta.prima}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Cuotas:</label> {{datosVenta.total_cuotas}}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Total intereses:</label> L. {{datosVenta.total_intereses}}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Total a pagar:</label> L. {{datosVenta.total_pagar}}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label>Cuota mensual:</label> {{datosVenta.cuota}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </template>
                    <template v-else>
                        <h2><label>Contado</label></h2>
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-dark">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="float-right align-self-stretch">
                                                            <h2>
                                                                <label>Total Contado:</label> {{datosVenta.contado_formato}}
                                                            </h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </template>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-striped">
                                    <table class="table table-sm responsive" id="lotes">
                                        <thead class="bg-dark">
                                            <tr>
                                                <td class="text-left">#</td>
                                                <td class="text-center">Lote</td>
                                                <td class="text-center">Residencial</td>
                                                <td class="text-center">Bloque</td>
                                                <td class="text-center">Precio</td>
                                                <td class="text-center">Años de Financiamiento</td>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(lotes,i) in datosLotesVendidos" :key="i">
                                                <td class="text-left">{{i+1}}. </td>
                                                <td class="text-center"><button type="button" class="btn btn-info btn-sm"> L-{{lotes.lote}} </button></td>
                                                <td class="text-center"> {{lotes.residencial}}</td>
                                                <td class="text-center"> <button type="button" class="btn btn-outline-dark btn-sm"> {{lotes.bloque}} </button></td>
                                                <td class="text-center"> L. {{lotes.precio}} </td>
                                                <td class="text-center"> {{lotes.tiempo}} años</td>                  
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
                
                <div class="modal-footer bg-warning">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" >Cerrar</button>
                    
                        <button type="button" class="btn btn-primary btn-sm" v-on:click="editarVenta()">Editar Venta</button>
                    
                </div>
                <div class="modal fade" id="modalAlertaEditarVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-exclamation-triangle"></i> <b> Advertencia</b></h5>
                                <button type="button" class="close" v-on:click="cerrarModalEditar()" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" />
                                <div class="row">
                                    <h5>
                                        <p class="text-justify">¿Desea realmente editar esta venta?</p>
                                        <p class="text-justify">El historial de cuotas de reiniciará.</p>
                                    </h5>
                                    <!-- <p class="text-justify">Si realiza esta accion se eliminaran todos los datos de esta venta sin posibilidad de recuperarlos.</p> -->
                                </div>
                            </div>

                            <div class="modal-footer bg-dark">
                                <button type="button" class="btn btn-info btn-sm btn-block" v-on:click="cerrarModalEditar()">Cancelar</button>
                                <button type="submit" class="btn btn-danger btn-sm btn-block" v-on:click="cambiarVenta(datosVenta.id_venta)">Editar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <modal-elegir-lote-component @infoLotes="infoLotes" :lotesFinanciados="lotesFinanciados"></modal-elegir-lote-component>
    </div>

</template>

<script>
export default {
props:["datosVenta", "datosLotesVendidos"],
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
        cuota_mensual:"",
        cliente:"",
        lotesFinanciados:[],
        creditoContado:0,
        accionCreditoContado:""

    }
},
mounted(){
        axios.get('/clientes').then(respuesta=>{
            this.clientes = respuesta.data
            //console.log(respuesta.data)
        })
        this.datosVenta.pago == 'Credito' ? this.creditoContado = 0 : this.creditoContado = 1;
        this.cuota_mensual = new Intl.NumberFormat('es-HN', { style: 'currency', currency: 'HNL' }).format(this.datosVenta.cuota);
},
methods:{
    cambioCreditoContado:function(){
        if(this.creditoContado == 1){
            this.creditoContado = 0
            this.datosVenta.pago = 'Contado'
        }else{
            this.creditoContado = 1
            this.datosVenta.pago = 'Credito'
        }
        
    },
    abrirModal:function(id_venta){
        axios.get('/lote_financiado/'+id_venta).then(respuesta=>{
            this.lotesFinanciados = respuesta.data
            console.log(respuesta.data)
            })

        $("#modalElegirLote").modal("show")
    },
    actualizarTabla:function(){
        axios.get('/lote_financiado/').then(respuesta=>{
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
            "prima":this.datosVenta.prima,
            "tiempo":this.datosVenta.anios_financiamiento,
            "interes":this.datosVenta.tasa_interes/100
        }
        axios.post('/lotes/apoyo/II', data).then(respuesta => {
            console.log(respuesta.data[0]);
            this.informacionLote = respuesta.data[0]
            this.datosVenta.anios_financiamiento = this.informacionLote.tiempo;
            this.datosVenta.total_cuotas = this.informacionLote.cuotas;
            this.datosVenta.total_intereses = this.informacionLote.interes;
            this.cuota_mensual = new Intl.NumberFormat('es-HN', { style: 'currency', currency: 'HNL' }).format(this.datosVenta.cuota)
        })
    },
    infoLotes:function(){
        axios.get("/lotes/apoyo/II/create").then(respuesta =>{
            this.informacionLote = respuesta.data[0]
            this.cuota_mensual = new Intl.NumberFormat('es-HN', { style: 'currency', currency: 'HNL' }).format(this.datosVenta.cuota)
            //console.log(respuesta.data[0])
        })
        //this.loteFinanciado()
        //this.actualizarTabla()
    },
    formatearCuotaMensual:function(){
        this.cuota_mensual = new Intl.NumberFormat('es-HN', { style: 'currency', currency: 'HNL' }).format(this.datosVenta.cuota)
    },
    editarVenta:function(){
        $("#modalAlertaEditarVenta").modal("show")
        
    },

    cerrarModalEditar:function(){
        $("#modalAlertaEditarVenta").modal("hide")
    },

    cambiarVenta:function(id_venta){
        //alert(id_venta)
        var data = null;
        if(this.creditoContado == 0){
            this.accionCreditoContado = 0
            data={
                "id_venta":this.datosVenta.id_venta,
                "cliente":this.datosVenta.identidad,
                "total_contado":this.datosVenta.contado,
                "anios_financiamiento":this.datosVenta.anios_financiamiento,
                "tasa_interes":this.datosVenta.tasa_interes,
                "prima":this.datosVenta.prima,
                "cuotas":this.datosVenta.total_cuotas,
                "total_intereses":this.datosVenta.total_intereses,
                "cuota_mensual":this.datosVenta.cuota,
                "dias_cobro_mensual":this.datosVenta.dias_cobro_mes,
                "total_pagar":this.datosVenta.total_pagar,
                "accionCreditoContado":this.accionCreditoContado
            }

         }else{
            this.accionCreditoContado = 1
            data={
                "id_venta":this.datosVenta.id_venta,
                "cliente":this.datosVenta.identidad,
                "total_contado":this.datosVenta.contado,
                "anios_financiamiento":this.datosVenta.anios_financiamiento,
                "tasa_interes":this.datosVenta.tasa_interes,
                "prima":this.datosVenta.prima,
                "cuotas":this.datosVenta.total_cuotas,
                "total_intereses":this.datosVenta.total_intereses,
                "cuota_mensual":this.datosVenta.cuota,
                "dias_cobro_mensual":this.datosVenta.dias_cobro_mes,
                "total_pagar":this.datosVenta.total_pagar,
                "accionCreditoContado":this.accionCreditoContado
            }
        }

        axios({
                   method:"put",
                   url:"venta/apoyo/"+id_venta,
                   data:data
               }).then(respuesta => {
                   console.log(respuesta.data)
                   alert(respuesta.data);
            $("#modalEditarVenta").modal("hide")
            $("#modalAlertaEditarVenta").modal("hide")
            this.$emit("actualizarVentas")
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