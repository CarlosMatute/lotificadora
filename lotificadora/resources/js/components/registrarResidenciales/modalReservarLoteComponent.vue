<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalReservarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-clock"></i> <b>Reservar Lote:</b> L-{{modoReservar.nombre}} </h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" v-model="modoReservar.id_bloque">
                        <input type="hidden" v-model="modoReservar.id">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Lote a Reservar:</label><br>
                                        <button class="btn btn-warning btn-block">L-{{modoReservar.nombre}}</button>
                                    </div>
                               </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Reservar para:</label>:
                                        <input type="text" v-model="nombre" class="form-control border-dark" placeholder="¿Quien reserva este lote?">
                                    </div>
                               </div>
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Reservar hasta:</label>:
                                        <input type="date" v-model="fecha" class="form-control border-dark">
                                    </div>
                               </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-on:click="reservarLote(modoReservar.id_bloque)">Reservar</button>
                    </div>
                </div>
            </div>
        </div>
    <!--</form>-->
</template>

<script>
export default {
    props:["modoReservar"],
    data(){
        return{
            nombre:"",
            fecha:""
        }
    },
    mounted(){


    },
    methods:{

           reservarLote:function(id){
               var data={
                   "nombre":this.nombre,
                   "fecha":this.fecha,
                   "idLote":this.modoReservar.id
               }
                axios({
                   method:"put",
                   url:"lotes/"+data.idLote,
                   data:{
                       "nombre":data.nombre,
                       "fecha":data.fecha

                   }
               }).then(respuesta => {
                $("#modalReservarLote").trigger('click')
                this.$emit("actualizarLotes",id)
            })
            this.nombre = "",
            this.fecha = ""

           },
            cerrarModal:function(){
            $("#modalReservarLote").trigger('click')
            //$("#modalBloques").modal("hide")
            }
        
    }

    
}
</script>