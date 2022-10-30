<template>
    <form @submit.prevent="agregarResidencial" enctype="multipart/form-data">
        <div class="modal fade" id="modalRegistrarResidencial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Registrar Nueva Residencial</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre de la Residencial</label>
                                        <input type="text" v-model="nombre" class="form-control border-dark" placeholder="Escribe el nombre">
                                    </div>
                               </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Numero de Bloques</label>
                                        <input type="number" v-model="nBloques" class="form-control border-dark" placeholder="Escribe la cantidad">
                                    </div>
                               </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Foto de la residencial</label>
                                           <input type="file" @change="obtenerImagen" class="form-control-file">
                                    </div>

                                    <figure>
                                        <img width="250" height="150" :src="img" alt="-No has seleccionado ninguna foto.">
                                    </figure>
                               </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea class="form-control border-dark" v-model="descripcion" id="" cols="30" rows="4" maxlength="255"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" >Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm">Guardar Residencial</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
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


        obtenerImagen(e){
            let file = e.target.files[0];
            this.imagen = file;
            this.cargarImagen(file);
            console.log(file);
        },

        cargarImagen(file){
            let reader = new FileReader();

            reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
            }
            reader.readAsDataURL(file);
        },
                agregarResidencial:function(){

            let formData = new FormData();
                    formData.append('nombre',this.nombre);
                    formData.append('nBloques',this.nBloques);
                    formData.append('descripcion',this.descripcion);
                    formData.append('imagen',this.imagen);

            axios.post('residenciales', formData).then(respuesta => {
                console.log(respuesta.data);
                this.nombre = "",
                this.nBloques = "",
                this.descripcion = "",
                this.imagen = "",
                this.imagenMiniatura = ""
                this.$emit("agregarResidencial")
                $("#modalRegistrarResidencial").trigger('click')
            })
 
             

            // $("#modalRegistrarResidencial").trigger('click')
           
        },
    },
    computed:{
        img(){
            return this.imagenMiniatura;
        }
    }
    
}
</script>