<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="jumbotron">
                    <h1 class="display-4 font-weight-bold"><i class="fa fa-money-bill"></i> COBROS RESTANTES DEL MES</h1>
                    <div class="card-body">
                        <div class="callout callout-info">
                            <h5>
                                <strong><i class="fa fa-info"></i> Nota: </strong>
                            </h5>
                            <p>Pantalla de información de clientes con pagos que no han sido cobrados del mes.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="small-box elevation-4 bg-info">
                            <div class="inner">
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <h3 class="text-capitalize">{{ resumenmorosos.movimientos['mes_actual'] }}</h3>
                                        <p>{{ resumenmorosos.movimientos['anio'] }}</p>
                                    </div>
                                    <div class="col-lg-2 col-md-4">
                                        <strong>
                                            <h4>L.{{ resumenmorosos.movimientos['total_pagado'] }}</h4>
                                        </strong>
                                        <p>Total Cobrado</p>
                                    </div>
                                    <div class="col-lg-2 col-md-4">
                                        <strong>
                                            <h4>L.{{ resumenmorosos.movimientos['restante'] }}</h4>
                                        </strong>
                                        <p>Total Restante </p>
                                    </div>
                                    <div class="col-lg-2 col-md-4">
                                        <strong>
                                            <h4>L.{{ resumenmorosos.movimientos['total_cobrar'] }}</h4>
                                        </strong>
                                        <p>Total a Cobrar</p>
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <center>
                                                    <h5 style="color: rgb(0, 166, 90)">
                                                        <strong>{{ resumenmorosos.movimientos['porcentaje_cobrado'] }}%</strong>
                                                    </h5>
                                                </center>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                                        role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        :style="'width: ' + resumenmorosos.movimientos['porcentaje_cobrado'] + '%'">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="/" class="small-box-footer"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="d-flex justify-content-between align-items-center">
                    <h4><label>Lista de Clientes</label></h4>
                    <div class="d-flex flex-column align-items-end">
                        <span class="badge badge-danger h4">Mora: L.{{ resumenmorosos.mora_total }}</span>
                        <span class="badge badge-success h4">Sin Mora: L.{{ resumenmorosos.sin_mora_total }}</span>
                    </div>
                </div>
                <ul class="nav nav-tabs mt-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="morosos-tab" data-toggle="tab" href="#morosos-tab-content"
                            role="tab" aria-controls="morosos-tab-content" aria-selected="true">Morosos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="estado-credito-tab" data-toggle="tab"
                            href="#estado-credito-tab-content" role="tab" aria-controls="estado-credito-tab-content"
                            aria-selected="false">Sin Mora</a>
                    </li>
                </ul>
                <div class="tab-content mb-3">
                    <div class="tab-pane fade show active" id="morosos-tab-content" role="tabpanel"
                        aria-labelledby="morosos-tab">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="table-responsive table-striped">
                            <table class="table table-striped table-bordered" style="width:100%" id="morosos">
                                <thead class="bg-dark">
                                    <tr>
                                        <td class="text-left">#</td>
                                        <td class="text-left">Venta</td>
                                        <td class="text-left">Cliente</td>
                                        <td class="text-left">Teléfono</td>
                                        <td class="text-left">Fecha de Cobro</td>
                                        <td class="text-center">Cobro Sugerido</td>
                                        <td class="text-center">Estado</td>
                                        <td class="text-center">Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(morosos, i) in resumenmorosos.morosos" :key="i">
                                        <td class="text-left">{{ i + 1 }}.</td>
                                        <td class="text-left">{{ morosos.fecha_formateada }}</td>
                                        <td class="text-left">{{ morosos.cliente }}</td>
                                        <td class="text-left">{{ morosos.cel }}</td>
                                        <td class="text-left">{{ morosos.fecha_cobro }}</td>
                                        <td class="text-right">L. {{ morosos.cuota_mensual }}</td>
                                        <td class="text-center">
                                            <template v-if="morosos.estado == 'Pendiente'">
                                                <span class="badge badge-info">{{ morosos.estado }}</span>
                                            </template>
                                            <template v-else-if="morosos.estado == 'Cola'">
                                                <span class="badge badge-primary">{{ morosos.estado }}</span>
                                            </template>
                                            <template v-else-if="morosos.estado == 'Atrasado'">
                                                <span class="badge badge-danger"><span
                                                        class="spinner-grow spinner-grow-sm" role="status"
                                                        aria-hidden="true"></span> {{ morosos.estado }}</span>
                                            </template>
                                            <template v-else-if="morosos.estado == 'Dia de cobro'">
                                                <span class="badge badge-warning"><span
                                                        class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span> {{ morosos.estado }}</span>
                                            </template>
                                            <template v-else>
                                                <span class="badge badge-success">{{ morosos.estado }}</span>
                                            </template>
                                        </td>
                                        <td class="text-center">


                                            <button type="button" class="btn btn-xs btn-secondary"
                                                v-on:click="estadoCredito(morosos.idV)"><i class="fa fa-share"></i>
                                                Cobrar</button>
                                            <button type="button" class="btn btn-xs btn-success"
                                                v-on:click="mensaje(morosos.cel)"><i class="fa fa-envelope"></i>
                                                WhatsApp</button>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    </div>
                    <div class="tab-pane fade" id="estado-credito-tab-content" role="tabpanel"
                        aria-labelledby="estado-credito-tab">
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="table-responsive table-striped">
                                    <table class="table table-striped table-bordered" style="width:100%" id="sin_mora">
                                        <thead class="bg-dark">
                                            <tr>
                                                <td class="text-left">#</td>
                                                <td class="text-left">Venta</td>
                                                <td class="text-left">Cliente</td>
                                                <td class="text-left">TelÃ©fono</td>
                                                <td class="text-left">Fecha de Cobro</td>
                                                <td class="text-center">Cobro Sugerido</td>
                                                <td class="text-center">Estado</td>
                                                <td class="text-center">Acciones</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(sin_mora, i) in resumenmorosos.sin_mora" :key="i">
                                                <td class="text-left">{{ i + 1 }}.</td>
                                                <td class="text-left">{{ sin_mora.fecha_formateada }}</td>
                                                <td class="text-left">{{ sin_mora.cliente }}</td>
                                                <td class="text-left">{{ sin_mora.cel }}</td>
                                                <td class="text-left">{{ sin_mora.fecha_cobro }}</td>
                                                <td class="text-right">L. {{ sin_mora.cuota_mensual }}</td>
                                                <td class="text-center">
                                                    <template v-if="sin_mora.estado == 'Pendiente'">
                                                        <span class="badge badge-info">{{ sin_mora.estado }}</span>
                                                    </template>
                                                    <template v-else-if="sin_mora.estado == 'Cola'">
                                                        <span class="badge badge-primary">{{ sin_mora.estado }}</span>
                                                    </template>
                                                    <template v-else-if="sin_mora.estado == 'Atrasado'">
                                                        <span class="badge badge-danger"><span
                                                                class="spinner-grow spinner-grow-sm" role="status"
                                                                aria-hidden="true"></span> {{ sin_mora.estado }}</span>
                                                    </template>
                                                    <template v-else-if="sin_mora.estado == 'Dia de cobro'">
                                                        <span class="badge badge-warning"><span
                                                                class="spinner-border spinner-border-sm" role="status"
                                                                aria-hidden="true"></span> {{ sin_mora.estado }}</span>
                                                    </template>
                                                    <template v-else>
                                                        <span class="badge badge-success">{{ sin_mora.estado }}</span>
                                                    </template>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-xs btn-secondary"
                                                        v-on:click="estadoCredito(sin_mora.idV)"><i class="fa fa-share"></i>
                                                        Cobrar</button>
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        v-on:click="mensaje(sin_mora.cel)"><i class="fa fa-envelope"></i>
                                                        WhatsApp</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <modal-estado-credito-component :estadoCreditoDatos="estadoCreditoDatos" @actualizarVentas="actualizarVentas"></modal-estado-credito-component>
    </div>

</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    props: ["resumenmorosos"],
    data() {
        return {
            estadoCreditoDatos: []

        }
    },
    mounted() {
        $('#morosos').DataTable();
        $('#sin_mora').DataTable();
    },
    methods: {
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

        actualizarVentas:function(){
            window.location.reload()
        },

           mensaje:function(celular){
            this.mensaje_texto = "Estimado cliente, le saluda Inversiones Rivera Carvajal, el motivo de este mensaje "+
                                "es para hacerle saber que tiene moras Pendientes. Por favor ponerse al día. Gracias."
            window.open('https://api.whatsapp.com/send?phone=504'+celular+'&text='+this.mensaje_texto+'','_blank');
         
           },
    }

}
</script>
