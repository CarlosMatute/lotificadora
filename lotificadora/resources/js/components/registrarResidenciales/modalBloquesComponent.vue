<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalBloques" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark" v-for="(residencial,i) in verBloques" :key="i">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-home"></i><b> Residencial:</b> {{residencial.nombre}}</h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-for="(residencial) in verBloques">
                        
                        <div class="row">
                                <div class="col-md-4">
                                    <img :src="'/storage/'+residencial.imagen" class="img-fluid elevation-2" alt="..." width="300" height="150">
                                    <button type="button" class="btn btn-link btn-sm" v-on:click="cambiarImagen(residencial.idResidencial)">Cambiar imagen</button>
                               </div>
                                <div class="col-md-8">
                                    <h2><b>Residencial:</b> {{residencial.nombre}}</h2>
                                    <p class="card-text"> {{residencial.descripcion}}</p>
                                    <p class="card-text"> <b>Bloques:</b> {{residencial.totalB}} &nbsp;&nbsp; <b>Lotes:</b> {{residencial.totalL}} &nbsp;&nbsp; 
                                    <b>Bloques con lotes:</b> <a v-for="(lotesEnBloques) in residencial.lotesEnBloques">{{lotesEnBloques.nombre}} </a></p>
                               </div>
                        </div>
                        <hr>
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h5><label>Bloques</label></h5>
                                        

                                    </div>
                               </div>
                        </div>
                        <div class="row">
                            <div v-for="(bloques) in residencial.bloques">
                                <button class="btn btn-outline-dark btn-lg" v-on:click="lotes(bloques.id)">{{bloques.nombre}}</button>&nbsp;
                            </div>
                            <button class="btn btn-outline-info btn-lg" v-on:click="agregarBloque(residencial.idResidencial)"><i class="fa fa-plus"></i></button>&nbsp;
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning" v-for="(residencial) in verBloques">
                        <button type="button" class="btn btn-dark btn-sm" v-on:click="eliminarResidencial(residencial.idResidencial)">Eliminar Residencial</button>
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" v-on:click="modoEditar(residencial.idResidencial)">Editar Residencial</button>
                    </div>
                </div>
            </div>

            <modal-lotes-component :verLotes="verLotes" @actualizarBloques="actualizarBloques"></modal-lotes-component>
            <modal-agregar-bloque-component :nuevoBloque="nuevoBloque" @actualizarBloques="actualizarBloques"></modal-agregar-bloque-component>
            <modal-editar-residencial-component :editarResidencial="editarResidencial" @actualizarBloques="actualizarBloques"></modal-editar-residencial-component>
            <modal-cambiar-imagen-residencial-component :editarResidencial="editarResidencial" @actualizarBloques="actualizarBloques"></modal-cambiar-imagen-residencial-component>
            <modal-alerta-eliminar-residencial-component :infoResidencialEliminar="infoResidencialEliminar" @cerrarModal="cerrarModal"></modal-alerta-eliminar-residencial-component>
        </div>
    <!--</form>-->
</template>

<script>
import datatables from 'datatables';
$.fn.DataTable = datatables;
export default {
    props:["verBloques"],
    data(){
        return{
            verLotes:[],
            nuevoBloque:[],
            editarResidencial:[],
            infoResidencialEliminar:[]

        }
    },
    mounted(){


    },
    methods:{

        lotes:function(id){
           axios.get("residenciales/"+id+"/edit").then(respuesta=>{
               console.log('lotes')
               console.log(respuesta.data)
               this.verLotes = respuesta.data[0]
               $("#lotes").dataTable().fnDestroy();
                $(function() {
                $('#lotes').DataTable();
                });
               $("#modalLotes").modal("show")
               })
        },
        
        actualizarBloques:function(idResidencial){
            axios.get("residenciales/"+idResidencial).then(respuesta=>{
                this.verBloques=respuesta.data
                })
        },

        agregarBloque:function(id){
            axios.get("bloque/"+id+"/edit").then(respuesta=>{
                console.log(respuesta.data)
                this.nuevoBloque = respuesta.data[0]
                $("#modalAgragarBloque").modal("show")
            })
        },

        modoEditar:function(id){
            axios.get("residenciales/"+id).then(respuesta=>{
                this.editarResidencial=respuesta.data[0]
                console.log('ver residenciales')
                console.log(respuesta.data)
                $("#modalEditarResidencial").modal("show")
                })
        },

        cambiarImagen:function(id){
            axios.get("residenciales/"+id).then(respuesta=>{
                this.editarResidencial=respuesta.data[0]
                console.log('ver residenciales')
                console.log(respuesta.data)
                $("#modalCambiarImagenResidencial").modal("show")
                })
        },

        cerrarModal:function(){
            this.$emit("actualizarResidenciales")
            //$("#modalBloques").trigger('click')
            $("#modalBloques").modal("hide")
        },

        eliminarResidencial:function(id){
            axios.get("residenciales/apoyo/"+id).then(respuesta=>{
                console.log("eliminar R?")
                console.log(respuesta.data)
                this.infoResidencialEliminar = respuesta.data[0]
            })

            $("#modalAlertaEliminarResidencial").modal("show")
        }
    }

    
}
</script>