<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalLotes" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary" v-for="(bloque,i) in verLotes.bloqueNombre" :key="i">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-cube"></i><b> Bloque:</b> {{bloque}} <b>&nbsp;&nbsp;&nbsp;&nbsp; Lotes:</b> {{verLotes.lotes.length}}</h5>
                        <button type="button" class="close" v-on:click="actualizarBloques(verLotes.idResidencial)" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-striped">
                                        <table class="table table-striped table table-sm responsive table-bordered" style="width:100%" id="lotes">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <td class="text-center">#</td>
                                                    <td class="text-center">Lote</td>
                                                    <td class="text-center">Area</td>
                                                    <td class="text-center">Medidas</td>
                                                    <td class="text-center">Precio</td>
                                                    <td class="text-center">Financiamiento</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center">Acciones</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(lotes,k) in verLotes.lotes" :key="k">
                                                    <td class="text-center">{{ k+1 }}. </td>
                                                    <td class="text-center">L-{{lotes.nombre}}</td>
                                                    <td class="text-center">{{lotes.area}}m²</td>
                                                    <td class="text-center"><b>Norte:</b> {{lotes.norte}}m. <b>Sur:</b> {{lotes.sur}}m. <b>Este:</b> {{lotes.este}}m. <b>Oeste:</b> {{lotes.oeste}}m.</td>
                                                    <td class="text-center">L. {{lotes.precio}}</td>
                                                    <td class="text-center">{{lotes.tiempo}} años</td>
                                                    <td class="text-center">
                                                        <template v-if="lotes.estado == 'Disponible'">
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Disponible" v-on:click="reservarLote(lotes.id)"><i class="fa fa-check"></i> {{lotes.estado}}</button>
                                                        </template>
                                                        <template v-else-if="lotes.estado == 'Reservado'">
                                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Reservado" v-on:click="reservacionLote(lotes.id)"><i class="fa fa-clock"></i> {{lotes.estado}}</button>
                                                        </template>
                                                        <template v-else>
                                                            <a type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Vendido" :href="'/detalle_lote_vendido/'+lotes.id" target="_blank"><i class="fa fa-handshake"></i> {{lotes.estado}}</a>
                                                        </template>
                                                    </td>
                                                    <td class="text-center" >
                                                        <div class="btn-group">
                                                            <template v-if="lotes.estado == 'Vendido'">
                                                                <button class="btn btn-warning btn-sm" v-on:click="modoEditar(lotes.id)"><i class="fa fa-edit" aria-hidden="true" ></i></button>
                                                                <button class="btn btn-danger btn-sm" disabled><i class="fas fa-trash"></i></button>
                                                            </template>
                                                            <template v-else>
                                                                <button class="btn btn-warning btn-sm" v-on:click="modoEditar(lotes.id)"><i class="fa fa-edit" aria-hidden="true" ></i></button>
                                                                <button class="btn btn-danger btn-sm" v-on:click="eliminar(lotes.id)"><i class="fas fa-trash" ></i></button>
                                                            </template>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                               </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-secondary">
                        <!--<button type="button" class="btn btn-success btn-sm" v-on:click="mytable" >Buscar</button>-->
                        <button type="button" class="btn btn-dark btn-sm" v-on:click="EliminarBloque(verLotes.idBloque)" >Eliminar Bloque</button>
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="actualizarBloques(verLotes.idResidencial)" >Cerrar</button>
                        <template v-if="verLotes.total == 0">
                            <button type="button" class="btn btn-primary btn-sm" v-on:click="lotes(verLotes.idBloque)" >Agregar Lotes</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-primary btn-sm" v-on:click="lote(verLotes.idBloque)" >Agregar Lote</button>
                        </template>
                    </div>
                </div>
            </div>
            <modal-agregar-lotes-component :bloqueInfo="bloqueInfo" @actualizarLotes="actualizarLotes"></modal-agregar-lotes-component>
            <modal-agregar-lote-component :bloqueInfo2="bloqueInfo2" @actualizarLotes="actualizarLotes"></modal-agregar-lote-component>
            <modal-editar-lote-component :modoEditarLote="modoEditarLote" @actualizarLotes="actualizarLotes"></modal-editar-lote-component>
            <modal-alerta-eliminar-bloque-component :infoBloqueEliminar="infoBloqueEliminar" @actualizarBloques="actualizarBloques"></modal-alerta-eliminar-bloque-component>
            <modal-reservar-lote-component :modoReservar="modoReservar" @actualizarLotes="actualizarLotes"></modal-reservar-lote-component>
            <modal-reservacion-lote-component :reservacion="reservacion" @actualizarLotes="actualizarLotes"></modal-reservacion-lote-component>
        </div>
    <!--</form>-->
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
   props:["verLotes"],
    data(){
        return{
            bloqueInfo:[],
            bloqueInfo2:[],
            modoEditarLote:[],
            infoBloqueEliminar:[],
            modoReservar:[],
            reservacion:[]

        }
    },
    mounted(){


    },
    methods:{
        myTable(){
           $(function() {
               $('#lotes').DataTable();
           });
       },
       myTableClear(){
           $("#lotes").dataTable().fnDestroy();
       },

        lotes:function(idBloque){
            axios.get("lotes/"+idBloque).then(respuesta=>{
                console.log("bloque")
                console.log(respuesta.data)
                this.bloqueInfo = respuesta.data
            })
            $("#modalAgragarLotes").modal("show")
        },

        lote:function(idBloque){
            axios.get("lotes/"+idBloque+"/edit").then(respuesta=>{
                console.log("bloque")
                console.log(respuesta.data[0])
                this.bloqueInfo2 = respuesta.data[0]
            })
            $("#modalAgragarLote").modal("show")
 
        },

        actualizarLotes:function(id){
            axios.get("residenciales/"+id+"/edit").then(respuesta=>{
               console.log('lotes')
               console.log(respuesta.data[0])
               this.myTableClear()
               this.verLotes = respuesta.data[0]
               this.myTable()
               })
        },

        eliminar:function(id){
            axios.delete("lotes/"+id).then(respuesta=>{
                console.log("lote eliminado")
                this.myTableClear()
                this.verLotes = respuesta.data[0]
                this.myTable()
            })
        },

        modoEditar:function(id){
            axios.get("lotes/apoyo/"+id).then(respuesta=>{
                console.log("modoEditar")
                console.log(respuesta.data[0])
                this.modoEditarLote = respuesta.data[0]
            })

            $("#modalEditarLote").modal("show")
        },

        EliminarBloque:function(id){
            axios.get("bloque/"+id).then(respuesta=>{
                console.log("eliminar?")
                console.log(respuesta.data)
                this.infoBloqueEliminar = respuesta.data[0]
            })

            $("#modalAlertaEliminarBloque").modal("show")
        },
        actualizarBloques:function(idResidencial){
            this.$emit("actualizarBloques",idResidencial)
            $("#modalLotes").modal("hide")
        },
        reservarLote:function(id){
            axios.get("lotes/apoyo/"+id).then(respuesta=>{
                this.modoReservar = respuesta.data[0]
            })

            $("#modalReservarLote").modal("show")
        },
        reservacionLote:function(id){
            axios.get("lotes/apoyo/"+id).then(respuesta=>{
                console.log("reservacion")
                console.log(respuesta.data[0])
                this.reservacion = respuesta.data[0]
            })

            $("#modalReservacionLote").modal("show") 
        }
    
    },

    
}
</script>