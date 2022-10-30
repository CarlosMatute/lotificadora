<template>
    <form @submit.prevent="agregarResidencial" enctype="multipart/form-data">
        <div class="modal fade" id="modalCambiarImagenResidencial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Cambiar imagen</h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nueva foto de la residencial</label>
                                           <input type="file" @change="obtenerImagen" class="form-control-file">
                                    </div>

                                    <figure>
                                        <img width="250" height="150" :src="img" alt="-No has seleccionado ninguna foto.">
                                    </figure>
                               </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm">Guardar Imagen</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
            imagenMiniatura:'',
            imagenVieja:'',
            idR:""

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
                    // formData.append('nombre',this.nombre);
                    // formData.append('nBloques',this.nBloques);
                    formData.append('imagenVieja',this.editarResidencial.imagen);
                    formData.append('imagen',this.imagen);
                    var data={
                        "idR":this.editarResidencial.idResidencial
                    }
                    
            axios.post('residenciales/apoyo', formData).then(respuesta => {
                console.log(respuesta.data);
                this.imagen = "",
                this.imagenMiniatura = ""
                this.$emit("actualizarBloques",data.idR)
                $("#modalCambiarImagenResidencial").trigger('click')
            })
 
             

            // $("#modalRegistrarResidencial").trigger('click')
           
        },
            cerrarModal:function(){
            $("#modalCambiarImagenResidencial").trigger('click')
            //$("#modalBloques").modal("hide")
            }
    },
    computed:{
        img(){
            return this.imagenMiniatura;
        }
    }
    
}
</script>