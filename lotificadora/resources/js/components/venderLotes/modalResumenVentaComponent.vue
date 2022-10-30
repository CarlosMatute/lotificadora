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
                    <div class="modal-body">
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
                                        <h3><label>Fecha y hora de venta:</label></h3>
                                        <h4> {{resumenDeVenta.fecha}} </h4>
                                        
                                    </div>
                               </div>
                        </div>
                        <hr>
                            <h2><label>Credito</label></h2>
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
                    </div>
                    
                    <div class="modal-footer bg-secondary">
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
        </div>
    
</template>

<script>
export default {
    props:["resumenDeVenta"],
    data(){
        return{


        }
    },
    mounted(){
  

    },
    methods:{
    cerrarModal:function(){
            this.$emit("actualizarVentas")
            $("#resumenVenta").modal("hide")
            //$("#modalEsatdoCredito").trigger('click')
        }
    }
    
}
</script>