<template>
<div class="container-fluid">
    <div class="row pt-3 pb-2 mb-3 border-bottom">
        <div class="col-md-10">
            <h4><i class="fa fa-chart-bar"></i> <b>Resumen Financiero:</b> {{data.residencial.nombre}}</h4>
        </div>
        <div class="col-md-2 text-right">
            <a :href="'/registrarResidenciales'" class="btn btn-danger btn-sm">Volver</a>
        </div>
    </div>

    <div class="callout callout-info">
        <h5><i class="fa fa-info"></i> Resumen General</h5>
        <p>Comparativa de ingresos esperados vs ingresos recaudados del residencial.</p>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>L. {{ formatNum(data.resumen.total_esperado) }}</h3>
                    <p>Total Esperado</p>
                </div>
                <div class="icon"><i class="fa fa-calculator"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>L. {{ formatNum(data.resumen.total_cobrado) }}</h3>
                    <p>Total Recaudado</p>
                </div>
                <div class="icon"><i class="fa fa-hand-holding-usd"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>L. {{ formatNum(pendiente) }}</h3>
                    <p>Pendiente de Cobro</p>
                </div>
                <div class="icon"><i class="fa fa-clock"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="small-box" :class="porcentaje >= 50 ? 'bg-success' : 'bg-danger'">
                <div class="inner">
                    <h3>{{ porcentaje }}%</h3>
                    <p>Recaudado vs Esperado</p>
                </div>
                <div class="icon"><i class="fa fa-percent"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <table class="table table-sm table-bordered">
                <tr><td><b>Total Ventas:</b></td><td>{{ data.resumen.total_ventas }}</td></tr>
                <tr><td><b>Ventas Pagadas:</b></td><td>{{ data.resumen.ventas_pagadas }}</td></tr>
                <tr><td><b>Ventas Pendientes:</b></td><td>{{ data.resumen.ventas_pendientes }}</td></tr>
                <tr><td><b>Total Contado:</b></td><td>L. {{ formatNum(data.resumen.total_contado) }}</td></tr>
            </table>
        </div>
    </div>

    <hr>
    <h5><label><i class="fa fa-list"></i> Detalle por Venta</label></h5>
    <div>
        <table class="table table-sm table-bordered table-striped" id="detalle_tabla" width="100%">
            <thead class="bg-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Identidad</th>
                    <th>Teléfono</th>
                    <th>Lotes</th>
                    <th>Pago</th>
                    <th>Estado</th>
                    <th>Esperado</th>
                    <th>Recaudado</th>
                    <th>Saldo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(venta,i) in data.detalle" :key="venta.id_venta">
                    <td>{{ i+1 }}</td>
                    <td>{{ venta.cliente }}</td>
                    <td>{{ venta.identidad }}</td>
                    <td>{{ venta.cel }}</td>
                    <td>{{ venta.lotes_texto }}</td>
                    <td><span class="badge" :class="venta.pago == 'Credito' ? 'badge-info' : 'badge-success'">{{ venta.pago }}</span></td>
                    <td>
                        <span class="badge" :class="{'badge-success': venta.estado == 'Pagado', 'badge-warning': venta.estado == 'Pendiente'}">{{ venta.estado }}</span>
                    </td>
                    <td class="text-right">L. {{ formatNum(venta.pago == 'Credito' ? venta.total_pagar : venta.total_contado) }}</td>
                    <td class="text-right">L. {{ formatNum(venta.cobrado) }}</td>
                    <td class="text-right" :class="{'text-success': venta.saldo == 0, 'text-danger': venta.saldo > 0}">L. {{ formatNum(venta.saldo) }}</td>
                    <td class="text-center">
                        <a :href="'/residenciales/venta/'+venta.id_venta+'/detalle'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-eye"></i> Ver</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pt-3 pb-3">
        <a :href="'/registrarResidenciales'" class="btn btn-danger btn-sm">Volver</a>
    </div>
</div>
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    props:["data"],
    computed:{
        pendiente:function(){
            return this.data.resumen.total_esperado - this.data.resumen.total_cobrado
        },
        porcentaje:function(){
            if(this.data.resumen.total_esperado == 0) return 0
            return Math.round(this.data.resumen.total_cobrado * 100 / this.data.resumen.total_esperado)
        }
    },
    mounted(){
        this.$nextTick(() => {
            $(function() {
                $('#detalle_tabla').DataTable({
                    pagingType: 'full_numbers',
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'Todos']],
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    language: {
                        search: 'Buscar:',
                        lengthMenu: 'Mostrar _MENU_ registros',
                        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                        infoFiltered: '(filtrado de _MAX_ registros totales)',
                        zeroRecords: 'No se encontraron registros',
                        emptyTable: 'No hay datos disponibles',
                        paginate: {
                            first: 'Primero',
                            previous: 'Anterior',
                            next: 'Siguiente',
                            last: 'Último'
                        }
                    },
                    columnDefs: [
                        { orderable: false, targets: [0, 10] }
                    ],
                    order: [[0, 'asc']]
                })
            })
        })
    },
    methods:{
        formatNum:function(n){
            return parseFloat(n).toLocaleString('es-HN', {minimumFractionDigits: 2, maximumFractionDigits: 2})
        }
    }
}
</script>

<style>
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.3em 0.7em;
    margin: 0 2px;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    background: #fff;
    color: #007bff !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: #007bff !important;
    color: #fff !important;
    border-color: #007bff;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #e9ecef !important;
    color: #0056b3 !important;
    border-color: #dee2e6;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
    color: #6c757d !important;
    background: #fff !important;
    border-color: #dee2e6;
    cursor: default;
}
.dataTables_wrapper {
    padding-top: 0.5em;
}
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 0.5em;
}
</style>
