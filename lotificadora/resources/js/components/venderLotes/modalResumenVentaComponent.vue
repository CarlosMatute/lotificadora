<template>
    
        <div class="modal fade" id="resumenVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-clipboard"></i> Resumen de Venta</h5>
                        <button type="button" class="close" v-on:click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="imprimir_resumen_venta">
                        <center><h1><label>Estado de Cuotas</label></h1></center>
                        <div class="row">
                                <div class="col-md-8">
                                     <div class="form-group">
                                        <h2><label>Cliente:</label></h2>
                                        <h3> {{resumenDeVenta.cliente}} </h3>
                                        <h4>{{resumenDeVenta.identidad}} - {{resumenDeVenta.cel}}</h4>
                                    </div>
                               </div>
                               <div class="col-md-4">
                                     <div class="form-group">
                                        <h3><label>Fecha de venta:</label></h3>
                                        <h4> {{resumenDeVenta.fecha}} 
                                            <small class="float-right">
                                                <div class="btn-group">
                                                    <button class="btn btn-light btn-sm" v-on:click="editarFecha(resumenDeVenta.id_venta)"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                </div>
                                            </small>
                                        </h4>
                                    </div>
                                    <div class="form-group">
                                        <sm><label>Venta registrada el :</label> {{resumenDeVenta.fecha_registro}}</sm>
                                    </div>
                               </div>
                        </div>
                        <hr>
                            <h2><label>Crédito</label></h2>
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="card bg-dark">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Total Contado:</label> L. {{resumenDeVenta.total_contado}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Financiamiento:</label> {{resumenDeVenta.anios_financiamiento}} años
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Tasa de interes anual:</label> {{resumenDeVenta.tasa_interes}}%
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Prima:</label> L. {{resumenDeVenta.prima}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Cuotas:</label> {{resumenDeVenta.cuotas}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Total intereses:</label> L. {{resumenDeVenta.total_intereses}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Total a pagar:</label> L. {{resumenDeVenta.total_pagar}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                                <label>Cuota mensual:</label> L. {{resumenDeVenta.cuota_mensual}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <hr>
                            <h2><label>Lotes</label></h2>
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
                                                <tr v-for="(lotes,i) in resumenDeVenta.lotes" :key="i">
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
                            <hr>
                            <h2><label>Historial de Cuotas</label></h2>
                            <div class="table-responsive table-striped">
                                        <table class="table table-sm responsive" style="width:100%" id="historial_cuotas">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Fecha Cobro</td>
                                                    <td class="text-center">Cobro Sugerido</td>
                                                    <td class="text-center">Fecha Pago</td>
                                                    <td class="text-center">Monto Pago</td>
                                                    <td class="text-center">Estado</td>
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
                                                                      
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                    </div>
                    
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-info btn-sm" v-on:click="imprimir()">Imprimir Resumen de Venta</button>
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal()">Cerrar</button>
                       <!-- <template v-if="cliente == '' || informacionLote == 0">
                            <button type="button" class="btn btn-primary btn-sm" disabled>Realizar Venta</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-primary btn-sm" v-on:click="ejecutarVenta()">Realizar Venta</button>
                        </template> -->
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalEditarVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> <b> Editar</b></h5>
                        <button type="button" class="close" v-on:click="cerrarModalEditarFechaVenta()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" >
                        <div class="row">
                                <div class="col-md-12 col-lg-12">
                                     <div class="form-group">
                                        <label>Fecha de venta:</label>
                                        <input type="date" v-model="fecha_venta" class="form-control border-dark">
                                    </div>
                               </div>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer bg-dark">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModalEditarFechaVenta()">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-on:click="editarVenta()">Editar</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    
</template>

<script>
export default {
    props:["resumenDeVenta", "estadoCreditoDatos"],
    data(){
        return{
            fecha_venta:"",
            id_venta:null,
            informacionLote:[]

        }
    },
    mounted(){
  

    },
    methods:{
    cerrarModal:function(){
            this.$emit("actualizarVentas")
            $("#resumenVenta").modal("hide")
            //$("#modalEsatdoCredito").trigger('click')
        },

    imprimir:function(){

                    var ficha = document.getElementById('imprimir_resumen_venta');
                    var ventimp = window.open(' ', 'popimpr');
                    ventimp.document.write( ficha.innerHTML );
                    ventimp.document.close();
                    ventimp.print( );
                    ventimp.close();
        },

        editarFecha:function(id){
            this.id_venta = id;
            $("#modalEditarVenta").modal("show")

        },
        cerrarModalEditarFechaVenta:function(){
            $("#modalEditarVenta").modal("hide")
        },
        editarVenta:function(){
            var data = {
                "id_venta":this.id_venta,
                "fecha_venta":this.fecha_venta
            }
            axios.post("lotes/apoyo/III", data).then(respuesta =>{
                this.informacionLote = respuesta.data
                console.log(this.informacionLote);
                window.location.reload();
            })
            
        }
    }
    
}
</script>