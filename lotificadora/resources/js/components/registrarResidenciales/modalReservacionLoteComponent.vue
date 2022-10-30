<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalReservacionLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-clock"></i> <b>Reservacion del Lote:</b> L-{{reservacion.nombre}} </h5>
                        <button type="button" class="close" v-on:click="cerrarModal(reservacion.id_bloque)" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" v-model="reservacion.id_bloque">
                        <input type="hidden" v-model="reservacion.id">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Lote a Reservado:</label><br>
                                        <button class="btn btn-warning btn-block">L-{{reservacion.nombre}}</button>
                                    </div>
                               </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <template v-if="this.boton == 0">
                                            <label>Reservado a:</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-info" type="button" id="button-addon1" v-on:click="editar"><i class="fa fa-edit"></i></button>
                                                </div>
                                                <input type="text" v-model="reservacion.reservado" class="form-control border-dark" placeholder="¿Quien reserva este lote?" disabled>
                                                <input type="date" v-model="reservacion.fecha" class="form-control border-dark" disabled>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label>Reservado a:</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <template v-if="this.botonCampos == 0">
                                                        <button class="btn btn-primary" type="button" id="button-addon1" v-on:click="guardar(reservacion.id)"><i class="fa fa-save"></i></button>
                                                    </template>
                                                    <template v-else>
                                                        <button class="btn btn-primary" type="button" id="button-addon1" v-on:click="guardar(reservacion.id)" disabled><i class="fa fa-save"></i></button>
                                                    </template>
                                                </div>
                                                <input type="text" v-model="reservacion.reservado" class="form-control border-dark" placeholder="¿Quien reserva este lote?" v-on:change="campos">
                                                <input type="date" v-model="reservacion.fecha" class="form-control border-dark" v-on:change="campos">
                                            </div>
                                        </template>
                                    </div>
                               </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal(reservacion.id_bloque)">Cerrar</button>
                        <button type="submit" class="btn btn-dark btn-sm" v-on:click="eliminarReservacion(reservacion.id_bloque)">Eliminar Reservacion</button>
                    </div>
                </div>
            </div>
        </div>
    <!--</form>-->
</template>

<script>
export default {
    props:["reservacion"],
    data(){
        return{
            nombre:"",
            boton:0,
            botonCampos:0,
            id:""
        }
    },
    mounted(){


    },
    methods:{
            campos:function(){
                if(this.reservacion.reservado == "" || this.reservacion.fecha == ""){
                    this.botonCampos = 1
                }else{
                    this.botonCampos = 0
                }
            },
            eliminarReservacion:function(id){
                axios.get("lotes/apoyo/II/"+this.reservacion.id).then(respuesta => {
                $("#modalReservacionLote").trigger('click')
                this.$emit("actualizarLotes",id)
                })
            },
            cerrarModal:function(id){
            $("#modalReservacionLote").trigger('click')
            //this.id = this.reservacion.id_bloque
            this.$emit("actualizarLotes",id)
            },
            editar:function(){
                this.boton = 1
            },
            guardar:function(id){
                var data={
                   "nombre":this.reservacion.reservado,
                   "fecha":this.reservacion.fecha,
                   "idLote":this.reservacion.id
               }
                axios({
                   method:"put",
                   url:"lotes/apoyo/II/"+data.idLote,
                   data:{
                       "nombre":data.nombre,
                       "fecha":data.fecha

                   }
               }).then(respuesta => {
                //$("#modalReservacionLote").trigger('click')
                //this.$emit("actualizarLotes",id)
            })
                this.boton = 0
            }
        
    }

    
}
</script>