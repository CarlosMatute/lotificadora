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
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="small-box elevation-4 bg-info">
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <h3 class="text-capitalize">{{meses.mesActual}}</h3>
                                <p>Balance del Mes Actual</p>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <strong><h4>L.{{meses.totalPagado}}</h4></strong>
                                <p>Total Cobrado</p>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <strong><h4>L.{{meses.totalRestante}}</h4></strong>
                                <p>Total Restante</p>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <strong><h4>L.{{meses.totalCobrar}}</h4></strong>
                                <p>Total a Cobrar</p>
                            </div>
                            <div class="col-lg-2 col-md-12">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <center><h5 style="color: rgb(0, 166, 90)"><strong>{{meses.porcentajeCobrado}}%</strong></h5></center>
                                        <div class="progress" style="height: 10px;" id="prueba">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#" v-on:click="verMasMeses(0)" class="small-box-footer"> Ver más <i class="fas fa-arrow-circle-right"></i> </a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalMovimientosMeses" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-balance-scale"></i>
                         Balances Mensuales por Año
                         </h5>
                        <button type="button" class="close" v-on:click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"> 
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Escribe un año:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="number" v-model="nuevoAnio" class="form-control float-right" id="reservation" maxlength="4"/>
                                        <div class="input-group-prepend">
                                            <button type="button" v-on:click="verMasMeses(nuevoAnio)" class="btn btn-primary">Ir &nbsp; <i class="fa fa-arrow-circle-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 text-right">
                                <label>Año seleccionado:</label>
                                <h1 id="anio"></h1>
                            </div>
                        </div>
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <template v-if="movimientosMeses.length != 0">
                                        <div v-for="(movimientosMes,i) in movimientosMeses" :key="i">
                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="small-box elevation-4 bg-info">
                                                        <div class="inner">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-12">
                                                                    <h3 class="text-capitalize">{{movimientosMes.mes}}</h3>
                                                                    <p>{{movimientosMes.anio}}</p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-4">
                                                                    <strong><h4>L.{{movimientosMes.total_pagado}}</h4></strong>
                                                                    <p>Total Cobrado</p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-4">
                                                                    <strong><h4>L.{{movimientosMes.restante}}</h4></strong>
                                                                    <p>Total Restante</p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-4">
                                                                    <strong><h4>L.{{movimientosMes.total_cobrar}}</h4></strong>
                                                                    <p>Total a Cobrar</p>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12">
                                                                    <div class="card bg-light mb-3">
                                                                        <div class="card-body">
                                                                            <center><h3 style="color: rgb(0, 166, 90)"><strong>{{movimientosMes.porcentaje_cobrado}}%</strong></h3></center>
                                                                            <div class="progress" style="height: 10px;" :id="i+1">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- <a href="#" v-on:click="verMasMeses()" class="small-box-footer"> Ver más <i class="fas fa-arrow-circle-right"></i> </a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <hr>
                                        <div class="alert alert-danger alert-dismissible">
                                            <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                                            <h5><i class="icon fas fa-ban"></i> ¡Alerta!</h5>
                                            No existen datos para el año seleccionado, por favor intente nuevamente ingresando otro año.
                                        </div>
                                    </template>
                                    
                                </div>
                            </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="card elevation-4 text-left bg-light">
           <div class="card-header text-muted text-center">
                <h5 class="display-5">Cuotas Mensuales </h5>
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
                            <!-- <small>Atrasado</small> -->
                                    <template v-if="meses.enero == 'Atrasado'">
                                        <h4 class="display-4">Atrasado</h4>
                                    </template>
                                    <template v-else-if="meses.enero == 'Dia de cobro'">
                                        <h4 class="display-4">Cobro</h4>
                                    </template>
                                    <template v-else>
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
                                        <h4 class="display-4">Al día</h4>
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
            cuotasMes:[],
            mesActual:"",
            anioActual:"",
            movimientosMeses:[],
            nuevoAnio:""
        }
    },
    mounted(){
            axios.get('/dashboard').then(respuesta=>{
                //console.log(respuesta.data[0])
                this.meses = respuesta.data[0]
                var porcentaje = respuesta.data[0]
                this.anioActual = this.meses.anioActual;
                //console.log(this.anioActual )
                
                $("#prueba").html('<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: '+porcentaje.porcentajeCobrado+'%"></div>');
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
            
        },

        verMasMeses:function(anio){
            axios.get('/dashboard/'+anio+'/edit').then(respuesta=>{
                this.movimientosMeses = respuesta.data
                var anio_actual = this.anioActual;
                var movimientos = respuesta.data
                    setTimeout( function() {
                        anio = anio == 0 ? anio_actual : anio
                        $("#anio").html(anio);
                        for(var i = 1; i <= movimientos.length; i++){
                            $("#"+i).html('<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: '+movimientos[i-1].porcentaje_cobrado+'%"></div>');
                        }
                    $("#modalMovimientosMeses").modal("show")
                    }, 50);
                this.nuevoAnio = ""
            })
            
        },

        cerrarModal:function(){
            $("#modalMovimientosMeses").modal("hide")
            //$("#modalEsatdoCredito").trigger('click')
        }
    }
    
}
</script>