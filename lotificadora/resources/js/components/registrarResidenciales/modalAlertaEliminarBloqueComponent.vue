<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalAlertaEliminarBloque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-exclamation-triangle"></i> <b> Advertencia</b></h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" >
                        <div class="row">
                                <h5><p class="text-justify">¿Desea eliminar el bloque <b>{{infoBloqueEliminar.bloque}}</b> con 
                                    <b> {{infoBloqueEliminar.totalLotes}} </b> lotes registrados?
                                </p></h5>
                                <p class="text-justify">Si realiza esta accion se eliminaran todos los datos de este bloque
                                    sin posibilidad de recuperarlos.
                                </p>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer bg-dark">
                        <button type="button" class="btn btn-info btn-sm btn-block" v-on:click="cerrarModal">Cancelar</button>
                        <button type="submit" class="btn btn-danger btn-sm btn-block" v-on:click="eliminarBloque(infoBloqueEliminar.idBloque)">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    <!--</form>-->
</template>

<script>
export default {
    props:["infoBloqueEliminar"],
    data(){
        return{
            idResidencial:""
        }
    },
    mounted(){


    },
    methods:{

           eliminarBloque:function(id){
               axios.delete("/bloque/"+id).then(respuesta => {
               $("#modalAlertaEliminarBloque").trigger('click')
               $("#modalLotes").trigger('click')
               this.$emit("actualizarBloques",respuesta.data)
            })

           },

            cerrarModal:function(){
            $("#modalAlertaEliminarBloque").trigger('click')
            //$("#modalBloques").modal("hide")
        }
        
    }

    
}
</script>