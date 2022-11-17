<template>
    <div class="container">
        <!--<div class="row">
            <div class="col-md-12">
                <div class="card elevation-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-calendar-check fa-4x" style=" width:600; height:600;"></i>   
                            </div>
                            <div class="col-md-8">
                                <h4 class=""><b>Bienvenido</b></h4>
                                <p class="text-muted">En este modulo puede registrar y administrar todos los clientes.</p>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group dropleft float-right align-self-stretch">                                        
                                    <button data-toggle="modal" data-target="#modalRegistrarCliente" class="btn btn-sm btn-primary float-right align-self-stretch">Registrar Cliente</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

        <div class="card elevation-4 text-left bg-light">
           <div class="card-header text-muted text-center">
                <h5 class="display-5">Cuotas del año {{meses.añoActual}} </h5>
            </div>
            <div class="card-body">
                <!--Inicia de enero a abril-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Enero </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.enero == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.enero == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.enero == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.enero == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(1)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Febrero </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.febrero == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.febrero == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.febrero == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.febrero == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(2)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Marzo </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.marzo == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.marzo == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.marzo == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.marzo == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(3)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Abril </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.abril == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.abril == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.abril == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.abril == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(4)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    
                </div>
                <!--Finaliza de enero a abril-->
                <!--Inicia de mayo a agosto-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Mayo </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.mayo == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.mayo == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.mayo == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.mayo == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(5)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Junio </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.junio == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.junio == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.junio == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.junio == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(6)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Julio </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.julio == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.julio == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.julio == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.julio == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(7)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Agosto </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.agosto == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.agosto == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.agosto == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.agosto == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(8)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    
                </div>
                <!--Finaliza de mayo a agosto-->
                <!--Inicia de septiembre a diciembre-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Septiembre </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.septiembre == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.septiembre == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.septiembre == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.septiembre == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(9)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Octubre </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.octubre == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.octubre == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.octubre == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.octubre == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(10)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Noviembre </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.noviembre == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.noviembre == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.noviembre == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.noviembre == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(11)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card elevation-1 bg-dark">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h3><strong>Diciembre </strong></h3>
                                </div>
                                <div class="col-md-2">
                                    <template v-if="meses.diciembre == 'Atrasado'">
                                        <button class="btn btn-danger btn-sm float-right align-self-stretch"><div class="spinner-grow spinner-grow-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else-if="meses.diciembre == 'Dia de cobro'">
                                        <button class="btn btn-warning btn-sm float-right align-self-stretch"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden"></span></div></button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success btn-sm float-right align-self-stretch"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </template>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center bg-secondary">
                                    <template v-if="meses.diciembre == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.diciembre == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al dia</h4>
                                    </template>
                        </div>
                        <div class="card-footer text-muted">
                            <button class="btn btn-primary btn-sm btn-block" v-on:click="cuotasDelMes(12)">Ver pagos</button>
                        </div>
                        </div>
                    </div>
                    
                </div>
                <!--Finaliza de septiembre a diciembre-->
            </div>
        </div>
        <modal-cuotas-mes-component :cuotasMes="cuotasMes" @actualizarEstados="actualizarEstados"></modal-cuotas-mes-component>
    </div>
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    data(){
        return{
            clientes:[],
            verInfoCliente:[],
            meses:[],
            cuotasMes:[]
        }
    },
    mounted(){
            axios.get('/dashboard').then(respuesta=>{
                //console.log(respuesta.data[0])
                this.meses = respuesta.data[0]
            })

    },
    methods:{
        cuotasDelMes:function(id){
            axios.get("/dashboard/"+id).then(respuesta=>{
                console.log(respuesta.data[0])
                this.cuotasMes = respuesta.data[0]
                $("#letrasMes").dataTable().fnDestroy();
                $(function() {
                $('#letrasMes').DataTable();
                });
                $("#modalCuotasMes").modal("show")
            })
            
        },
        actualizarEstados:function(id){
            axios.get('/dashboard').then(respuesta=>{
                //console.log(respuesta.data[0])
                this.meses = respuesta.data[0]
            })
            
        }
    }
    
}
</script>