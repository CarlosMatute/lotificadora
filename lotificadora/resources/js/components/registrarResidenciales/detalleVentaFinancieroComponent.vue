<template>
<div class="container-fluid">
    <div class="row pt-3 pb-2 mb-3 border-bottom">
        <div class="col-md-10">
            <h4><i class="fa fa-file-invoice"></i> <b>Detalle de Venta #{{data.venta.id}}</b></h4>
        </div>
        <div class="col-md-2 text-right">
            <a href="javascript:history.back()" class="btn btn-danger btn-sm">Volver</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="callout callout-info">
                <h5><i class="fa fa-user"></i> Cliente</h5>
                <p><b>Nombre:</b> {{data.venta.cliente}}<br>
                <b>Identidad:</b> {{data.venta.identidad}}<br>
                <b>Teléfono:</b> {{data.venta.cel}}<br>
                <b>Teléfono 2:</b> {{data.venta.cel2}}<br>
                <b>Correo:</b> {{data.venta.correo}}<br>
                <b>Dirección:</b> {{data.venta.direccion}}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-warning">
                <h5><i class="fa fa-tag"></i> Venta</h5>
                <p><b>Estado:</b> <span class="badge" :class="data.venta.estado == 'Pagado' ? 'badge-success' : 'badge-warning'">{{data.venta.estado}}</span><br>
                <b>Tipo de pago:</b> <span class="badge" :class="data.venta.pago == 'Credito' ? 'badge-info' : 'badge-success'">{{data.venta.pago}}</span><br>
                <b>Total Contado:</b> L. {{ formatNum(data.venta.total_contado) }}<br>
                <b v-if="data.venta.pago == 'Credito'">Total a Pagar:</b><b v-else>Total Pagado:</b> L. {{ formatNum(data.venta.pago == 'Credito' ? data.venta.total_pagar : data.venta.total_contado) }}<br>
                <b>Total Cobrado:</b> L. {{ formatNum(data.totalCobrado) }}<br>
                <b>Saldo Pendiente:</b> <span :class="saldo > 0 ? 'text-danger' : 'text-success'">L. {{ formatNum(saldo) }}</span></p>
            </div>
        </div>
    </div>

    <template v-if="data.venta.pago == 'Credito'">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-sm table-bordered">
                    <tr><td><b>Años Financiamiento:</b></td><td>{{data.venta.anios_financiamiento}}</td></tr>
                    <tr><td><b>Tasa Interés:</b></td><td>{{data.venta.tasa_interes}}%</td></tr>
                    <tr><td><b>Prima:</b></td><td>L. {{ formatNum(data.venta.prima) }}</td></tr>
                    <tr><td><b>Cuotas:</b></td><td>{{data.venta.cuotas}}</td></tr>
                    <tr><td><b>Cuota Mensual:</b></td><td>L. {{ formatNum(data.venta.cuota_mensual) }}</td></tr>
                    <tr><td><b>Total Intereses:</b></td><td>L. {{ formatNum(data.venta.total_intereses) }}</td></tr>
                </table>
            </div>
        </div>
    </template>

    <hr>
    <h5><label><i class="fa fa-cubes"></i> Lotes</label></h5>
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-striped">
            <thead class="bg-dark">
                <tr>
                    <th>#</th>
                    <th>Lote</th>
                    <th>Bloque</th>
                    <th>Residencial</th>
                    <th>Área</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(lote,i) in data.lotes" :key="i">
                    <td>{{i+1}}</td>
                    <td>L-{{lote.nombre}}</td>
                    <td>{{lote.bloque}}</td>
                    <td>{{lote.residencial}}</td>
                    <td>{{lote.area}} m²</td>
                    <td class="text-right">L. {{ formatNum(lote.precio) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <template v-if="data.venta.pago == 'Credito'">
        <hr>
        <h5><label><i class="fa fa-history"></i> Historial de Cuotas</label></h5>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped" id="historial_tabla" width="100%">
                <thead class="bg-dark">
                    <tr>
                        <th>#</th>
                        <th>Fecha de Cobro</th>
                        <th>Fecha de Pago</th>
                        <th>Cantidad Pagada</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(cuota,i) in data.historialCuotas" :key="cuota.id">
                        <td>{{i+1}}</td>
                        <td>{{cuota.fecha_cobro}}</td>
                        <td>
                            <template v-if="cuota.fecha_pago == null">-</template>
                            <template v-else>{{cuota.fecha_pago}}</template>
                        </td>
                        <td class="text-right">
                            <template v-if="cuota.cantidad_pago == null">-</template>
                            <template v-else>L. {{ formatNum(cuota.cantidad_pago) }}</template>
                        </td>
                        <td>
                            <span class="badge" :class="{
                                'badge-success': cuota.estadoFC == 'Pagado',
                                'badge-info': cuota.estadoFC == 'Pendiente',
                                'badge-warning': cuota.estadoFC == 'Dia de cobro',
                                'badge-danger': cuota.estadoFC == 'Atrasado',
                                'badge-primary': cuota.estadoFC == 'Cola'
                            }">{{cuota.estadoFC}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>

    <div class="pt-3 pb-3">
        <a href="javascript:history.back()" class="btn btn-danger btn-sm">Volver</a>
    </div>
</div>
</template>

<script>
export default {
    props:["data"],
    computed:{
        saldo:function(){
            var total = this.data.venta.pago == 'Credito'
                ? parseFloat(this.data.venta.total_pagar.replace(/,/g, ''))
                : parseFloat(this.data.venta.total_contado.replace(/,/g, ''))
            return total - this.data.totalCobrado
        }
    },
    methods:{
        formatNum:function(n){
            if(typeof n == 'string') n = parseFloat(n.replace(/,/g, ''))
            return parseFloat(n).toLocaleString('es-HN', {minimumFractionDigits: 2, maximumFractionDigits: 2})
        }
    }
}
</script>
