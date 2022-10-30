<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalAlertaEliminarResidencial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <h5><p class="text-justify">¿Desea eliminar la residencial <b>{{infoResidencialEliminar.nombre}}</b> con 
                                    <b> {{infoResidencialEliminar.bloques}} </b>bloques y<b> {{infoResidencialEliminar.lotes}} </b>lotes registrados?
                                </p></h5>
                                <p class="text-justify">Si realiza esta accion se eliminaran todos los datos de esta residencial
                                    sin posibilidad de recuperarlos.
                                </p>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer bg-dark">
                        <button type="button" class="btn btn-info btn-sm btn-block" v-on:click="cerrarModal">Cancelar</button>
                        <button type="submit" class="btn btn-danger btn-sm btn-block" v-on:click="eliminarResidencial(infoResidencialEliminar.idR)">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    <!--</form>-->
</template>

<script>
export default {
    props:["infoResidencialEliminar"],
    data(){
        return{
            idResidencial:""
        }
    },
    mounted(){


    },
    methods:{

           eliminarResidencial:function(id){
               axios.delete("/residenciales/apoyo/"+id).then(respuesta => {
               $("#modalAlertaEliminarResidencial").trigger('click')
              // $("#modalLotes").trigger('click')
               this.$emit("cerrarModal")
            })

           },

            cerrarModal:function(){
            $("#modalAlertaEliminarResidencial").trigger('click')
            //$("#modalBloques").modal("hide")
            }
    }

    
}
</script>