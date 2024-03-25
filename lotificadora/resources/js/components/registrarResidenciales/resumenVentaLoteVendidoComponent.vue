<template>
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="jumbotron">
                <h1 class="display-4 font-weight-bold"><i class="fa fa-file"></i> RESUMEN DE VENTA</h1>
                <div class="card-body">
                    <div class="callout callout-info">
                        <h5>
                            <strong><i class="fa fa-info"></i> Nota: </strong>
                        </h5>
                        <p>Pantalla de información general de la venta.</p>
                    </div>
                </div>
            </div>
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-tag"></i> información de Venta
                            <small class="float-right">Fecha de registro: {{resumenventa.fecha_registro}}</small>
                        </h4>
                    </div>
                </div>

                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <strong>Cliente</strong>
                        <address>
                            Nombre: {{resumenventa.cliente}}<br />
                            Identidad: {{resumenventa.identidad}}<br />
                            Teléfono: {{resumenventa.cel}}<br />
                            Teléfono2: {{resumenventa.cel2}}<br />
                            Correo: {{resumenventa.correo}}
                        </address>
                    </div>

                    <div class="col-sm-4 invoice-col">
                        <strong>Venta</strong>
                        <address>
                            Estado de la venta: {{resumenventa.estado}}<br />
                            Financiamiento: {{resumenventa.anios_financiamiento}}<br />
                            Tasa de interes anual: {{resumenventa.tasa_interes}}<br />
                            Prima: {{resumenventa.prima}}<br />
                            Cuotas: {{resumenventa.cuotas}}<br />
                            Cuota mensual: {{resumenventa.cuota_mensual}}
                        </address>
                    </div>

                    <div class="col-sm-4 invoice-col">
                        <!-- <b>Invoice #007612</b><br /> -->
                        <br />
                        Tipo de venta: {{resumenventa.pago}}<br />
                        Total Contado: L.{{resumenventa.total_contado}}<br />
                        Total intereses: {{resumenventa.total_intereses}}<br />
                        Total a pagar: {{resumenventa.total_pagar}}<br />
                        Fecha de venta: {{resumenventa.fecha}}<br />
                        <b>N° Venta #{{resumenventa.id_venta}}</b>
                    </div>
                </div>
            </div>

            <hr />
            <h4><label>Lotes</label></h4>
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
                                <tr v-for="(lotes,i) in resumenventa.lotes" :key="i">
                                    <td class="text-left">{{i+1}}.</td>
                                    <td class="text-center"><button type="button" class="btn btn-info btn-sm">L-{{lotes.nombre}}</button></td>
                                    <td class="text-center">{{lotes.residencial}}</td>
                                    <td class="text-center"><button type="button" class="btn btn-outline-dark btn-sm">{{lotes.bloque}}</button></td>
                                    <td class="text-center">L. {{lotes.precio}}</td>
                                    <td class="text-center">{{lotes.tiempo}} años</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <template v-if="resumenventa.pago == 'Credito'">
                <hr />
                <h4><label>Historial de Cuotas</label></h4>
                <div class="table-responsive table-striped">
                    <table class="table table-sm responsive" style="width: 100%;" id="historial_cuotas">
                        <thead class="bg-dark">
                            <tr>
                                <td class="text-left">#</td>
                                <td class="text-center">Fecha de Cobro</td>
                                <td class="text-center">Cobro Sugerido</td>
                                <td class="text-center">Fecha de Pago</td>
                                <td class="text-center">Monto Pagado</td>
                                <td class="text-center">Estado</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(cobroMensual,i) in resumenventa.historialCuotas" :key="i">
                                                        <td class="text-left">{{i+1}}. </td>
                                                        <td class="text-center"> {{cobroMensual.fecha_cobro}} </td>
                                                        <td class="text-center"> L. {{cobroMensual.cuota_mensual}}  </td>
                                                        <td class="text-center"> 
                                                            <template v-if="cobroMensual.fecha_pago == null">Sin datos</template>
                                                            <template v-else>{{cobroMensual.fecha_pago}}</template> 
                                                        </td>
                                                        <td class="text-center"> 
                                                            <template v-if="cobroMensual.cantidad_pago == null">Sin datos</template>
                                                            <template v-else>{{cobroMensual.cantidad_pago}}</template>
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
            </template>
        </div>
    </div>
</div>

</template>

<script>
export default {
    props:["resumenventa"],
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