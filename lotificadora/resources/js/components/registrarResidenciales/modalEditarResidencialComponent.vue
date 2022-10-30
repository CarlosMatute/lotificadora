<template>
        <div class="modal fade" id="modalEditarResidencial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Editar Residencial</h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre de la Residencial:</label>
                                        <input type="text" v-model="editarResidencial.nombre" class="form-control border-dark" placeholder="Escribe el nombre">
                                    </div>
                               </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descripcion:</label>
                                    <textarea class="form-control border-dark" v-model="editarResidencial.descripcion" id="" cols="30" rows="4" maxlength="255"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" v-on:click="cambiarResidencial(editarResidencial.idResidencial)">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    props:["editarResidencial"],
    data(){
        return{
            nombre:"",
            nBloques:"",
            descripcion:"",
            imagen:'',
            imagenMiniatura:''

        }
    },
    mounted(){


    },
    methods:{

        cambiarResidencial:function(id){       
            axios({
                   method:"put",
                   url:'residenciales/'+id,
                    data:{
                       "nombre":this.editarResidencial.nombre,
                       "descripcion":this.editarResidencial.descripcion
                   }

            }).then(respuesta => {
                console.log(respuesta.data);
                $("#modalEditarResidencial").trigger('click')
                this.$emit("actualizarBloques",id)

            })
        },

          cerrarModal:function(){
            $("#modalEditarResidencial").trigger('click')
            //$("#modalBloques").modal("hide")
            }
    }

    
}
</script>