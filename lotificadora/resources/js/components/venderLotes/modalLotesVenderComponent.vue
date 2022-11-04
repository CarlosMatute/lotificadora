<template>
    
        <div class="modal fade" id="modalLotesVeder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-tag"></i> Registrar Nueva Venta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                       
                        <div class="row">
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label>Cliente:</label>
                                        <input list="browsers" v-model="cliente" class="form-control border-dark" id="browser"  autocomplete="off">
                                        <datalist id="browsers">
                                            <option v-for="cliente in clientes" v-bind:value="cliente.identidad"> {{cliente.primer_nombre}} {{cliente.segundo_nombre}} {{cliente.primer_apellido}} {{cliente.segundo_apellido}}</option>
                                        </datalist>
                                    </div>
                               </div>
                               <template v-if="informacionLote == 0">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Agregar Lotes:</label>
                                            <div>
                                            <button type="button" class="btn btn-secondary btn-block" v-on:click="abrirModal()">Lotes</button>
                                            </div>
                                        </div>
                                    </div>
                               </template>
                               <template v-else>
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Agregar Lotes:</label>
                                                <div>
                                                <button type="button" class="btn btn-secondary btn-block" v-on:click="abrirModal()">Lotes</button>
                                                </div>
                                            </div>
                                    </div>
                                    <template v-if="creditoContado == 0" && >
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
                               </template>
                               
                        </div>
                               <!--<template v-if="informacionLote == 0">
                                <div class="col-md-2">
                                     <div class="form-group">
                                        <label>Prima:</label>
                                        <input type="number" class="form-control border-dark" disabled>
                                    </div>
                               </div>
                               <div class="col-md-2">
                                     <div class="form-group">
                                        <label>Tasa de interes anual:</label>
                                        <input type="number" class="form-control border-dark" disabled>
                                    </div>
                               </div>
                               <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Dias cobro al mes:</label>
                                        <div class="input-group">
                                            <input type="range" class="form-control" min="1" max="30" disabled>
                                            <div class="input-group-prepend">
                                                &nbsp;<button class="form-control form-group">{{dias}}</button>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Años de financiamiento:</label>
                                        <div>
                                            <select disabled class="form-control border-dark">
                                                <option value="" selected disabled>--Elija un año--</option>
                                                <option value="">1 año</option>
                                                <option value="">2 años</option>
                                                <option value="">3 años</option>
                                                <option value="">4 años</option>
                                                <option value="">5 años</option>
                                                <option value="">6 años</option>
                                            </select>
                                        </div>
                                    </div>
                               </div>
                               </template>
                               <template v-else>-->
                                <!--</template>-->
                        <hr>
                        <!--<input type="hidden" v-model="informacionLote.idLote">-->
                        <template v-if="informacionLote == 0 && creditoContado == 0">
                            
                        </template>
                        <template v-else-if="informacionLote != 0 && creditoContado != 0">
                            <h2><label>Credito</label></h2>
                            <div class="row">
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <label>Prima:</label>
                                        <input type="number" v-model="prima" v-on:change="cambioPrimaTiempo" class="form-control border-dark">
                                    </div>
                               </div>
                               <div class="col-md-2">
                                     <div class="form-group">
                                        <label>Tasa de interes anual:</label>
                                        <input type="number" v-model="interes" v-on:change="cambioPrimaTiempo" class="form-control border-dark">
                                    </div>
                               </div>
                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Dias cobro al mes:</label>
                                        <div class="input-group">
                                            <input type="range" v-model="dias" class="form-control" min="1" max="30">
                                            <div class="input-group-prepend">
                                                &nbsp;<button class="form-control form-group">{{dias}}</button>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Años de financiamiento:</label>
                                        <div>
                                            <select v-model="informacionLote.tiempo" v-on:change="cambioPrimaTiempo" class="form-control border-dark">
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
                                        <input type="number" v-model="informacionLote.valorCuotaMensual" v-on:change="formatearCuotaMensual" class="form-control border-dark">
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
                                                                <label>Total Contado:</label> L. {{informacionLote.precioContado}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Financiamiento:</label> {{informacionLote.tiempo}} años
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Tasa de interes anual:</label> {{interes}}%
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Prima:</label> L. {{prima}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Cuotas:</label> {{informacionLote.cuotas}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Total intereses:</label> L. {{informacionLote.interes}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Total a pagar:</label> L. {{informacionLote.precioCredito}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Cuota mensual:</label>{{cuota_mensual}}
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
                                                                    <label>Total Contado:</label> {{informacionLote.contado}}
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
                                                <tr v-for="(lotes,i) in informacionLote.lotesApartados" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-center"><button type="button" class="btn btn-info btn-sm"> L-{{lotes.nombre}} </button></td>
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
                        <template v-if="cliente == '' || informacionLote == 0">
                            <button type="button" class="btn btn-primary btn-sm" disabled>Realizar Venta</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-primary btn-sm" v-on:click="ejecutarVenta()">Realizar Venta</button>
                        </template> 
                    </div>
                </div>
            </div>
            <modal-elegir-lote-component @infoLotes="infoLotes" :lotesFinanciados="lotesFinanciados"></modal-elegir-lote-component>
        </div>
    
</template>

<script>
export default {
    //props:["lotesFinanciados"],
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

    },
    methods:{
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
                console.log(respuesta.data);
                this.informacionLote = respuesta.data[0]
                this.cuota_mensual = new Intl.NumberFormat('es-HN', { style: 'currency', currency: 'HNL' }).format(this.informacionLote.valorCuotaMensual)
            })
        },
        infoLotes:function(){
            axios.get("/lotes/apoyo/II/create").then(respuesta =>{
                this.informacionLote = respuesta.data[0]
                this.cuota_mensual = new Intl.NumberFormat('es-HN', { style: 'currency', currency: 'HNL' }).format(this.informacionLote.valorCuotaMensual)
                //console.log(respuesta.data[0])
            })
            //this.loteFinanciado()
            //this.actualizarTabla()
        },
        formatearCuotaMensual:function(){
            this.cuota_mensual = new Intl.NumberFormat('es-HN', { style: 'currency', currency: 'HNL' }).format(this.informacionLote.valorCuotaMensual)
        },
        ejecutarVenta:function(){
            if(this.creditoContado == 0){
                this.accionCreditoContado = 0
                var data={
                    "cliente":this.cliente,
                    "total_contado":this.informacionLote.contado,
                    "anios_financiamiento":this.informacionLote.tiempo,
                    "tasa_interes":this.interes,
                    "prima":this.prima,
                    "cuotas":this.informacionLote.cuotas,
                    "total_intereses":this.informacionLote.interes,
                    "cuota_mensual":this.informacionLote.valorCuotaMensual,
                    "dias_cobro_mensual":this.dias,
                    "total_pagar":this.informacionLote.precioCredito,
                    "accionCreditoContado":this.accionCreditoContado
                }

             }else{
                this.accionCreditoContado = 1
                var data={
                    "cliente":this.cliente,
                    "total_contado":this.informacionLote.precioContado,
                    "anios_financiamiento":this.informacionLote.tiempo,
                    "tasa_interes":this.interes,
                    "prima":this.prima,
                    "cuotas":this.informacionLote.cuotas,
                    "total_intereses":this.informacionLote.interes,
                    "cuota_mensual":this.informacionLote.valorCuotaMensual,
                    "dias_cobro_mensual":this.dias,
                    "total_pagar":this.informacionLote.precioCredito,
                    "accionCreditoContado":this.accionCreditoContado
                }
            }

            axios.post('/venta',data).then(respuesta => {
                this.informacionLote = 0,
                this.cliente = "",
                this.prima = 0,
                this.interes = 4,
                this.dias = 30
                this.$emit("actualizarVentas")
                $("#modalLotesVeder").trigger('click')
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