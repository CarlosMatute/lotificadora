<template>
    
        <div class="modal fade" id="modalRegistrarVenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Registrar Nueva Venta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                        <div class="row">
                                <div class="col-md-4">
                                     <div class="form-group">
                                        <label>Cliente:</label>
                                        <input list="browsers" class="form-control border-dark" id="browser">
                                        <datalist id="browsers">
                                            <option v-for="cliente in clientes" v-bind:value="cliente.identidad"> {{cliente.primer_nombre}} {{cliente.segundo_nombre}} {{cliente.primer_apellido}} {{cliente.segundo_apellido}}</option>
                                        </datalist>
                                    </div>
                               </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Lotes a vender:</label>
                                        <div>
                                        <button type="button" class="btn btn-primary btn-block" v-on:click="modalLotesVender">Lotes</button>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Dias de pago al mes:</label>
                                        <div class="input-group">
                                            <input type="range" v-model="dias" class="form-control" min="1" max="30">
                                            <div class="input-group-prepend">
                                                &nbsp;<button class="form-control form-group">{{dias}}</button>
                                            </div>
                                        </div>
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
                        <button type="button" class="btn btn-primary btn-sm">Guardar Residencial</button>
                    </div>
                </div>
            </div>
            
        </div>
    
</template>

<script>
export default {
    data(){
        return{
            nombre:"",
            nBloques:"",
            descripcion:"",
            imagen:'',
            imagenMiniatura:'',
            dias:1,
            clientes:[],
            lotesFinanciados:[]

        }
    },
    mounted(){
            axios.get('/clientes').then(respuesta=>{
                this.clientes = respuesta.data
                //console.log(respuesta.data)
            })

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
        modalLotesVender:function(){
                //axios.get('/lote_financiado').then(respuesta=>{
               // this.lotesFinanciados = respuesta.data
                //console.log("lotes financiados")
               // console.log(respuesta.data)
                $("#modalLotesVeder").modal("show")
            //})
        },
        lotesVender:function(){
            
        }
    },
    computed:{
        img(){
            return this.imagenMiniatura;
        }
    }
    
}
</script>