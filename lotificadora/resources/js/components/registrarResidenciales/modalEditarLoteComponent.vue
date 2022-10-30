<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalEditarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> <b>Editar Lote:</b> L-{{modoEditarLote.nombre}} </h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" v-model="modoEditarLote.id_bloque">
                        <input type="hidden" v-model="modoEditarLote.id">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lote a Editar:</label><br>
                                        <button class="btn btn-warning btn-block">L-{{modoEditarLote.nombre}}</button>
                                    </div>
                               </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Precio</label> L.:
                                        <input type="number" v-model="modoEditarLote.precio" class="form-control border-dark" placeholder="Precio del lote">
                                    </div>
                               </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Norte</label> m:
                                    <input type="number" v-model="modoEditarLote.norte" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sur</label> m:
                                    <input type="number" v-model="modoEditarLote.sur" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Este</label> m:
                                    <input type="number" v-model="modoEditarLote.este" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Oeste</label> m:
                                    <input type="number" v-model="modoEditarLote.oeste" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Area</label> m²:
                                        <input type="number" v-model="modoEditarLote.area" class="form-control border-dark" placeholder="Area del lote">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Años de financiamiento:</label>
                                        <input type="number" v-model="modoEditarLote.tiempo" class="form-control border-dark" placeholder="¿Cuantos años?">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-on:click="editarLote(modoEditarLote.id_bloque)">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    <!--</form>-->
</template>

<script>
export default {
    props:["modoEditarLote"],
    data(){
        return{

        }
    },
    mounted(){


    },
    methods:{
            calcularArea:function(){
                this.modoEditarLote.area = 0;
                var norte = this.modoEditarLote.norte;
                var sur = this.modoEditarLote.sur;
                var este = this.modoEditarLote.este
                var oeste = this.modoEditarLote.oeste
                norte = parseFloat(norte);
                sur = parseFloat(sur);
                este = parseFloat(este);
                oeste = parseFloat(oeste);
                var suma = (norte + sur);
                var division = suma / 2;
                var suma2 = (este + oeste);
                var division2 = suma2 / 2;
                var area = division * division2;
                this.modoEditarLote.area = area;
            },
           editarLote:function(id){
               var data={
                   "precio":this.modoEditarLote.precio,
                   "area":this.modoEditarLote.area,
                   "norte":this.modoEditarLote.norte,
                   "sur":this.modoEditarLote.sur,
                   "este":this.modoEditarLote.este,
                   "oeste":this.modoEditarLote.oeste,
                   "idBloque":this.modoEditarLote.id_bloque,
                   "idLote":this.modoEditarLote.id,
                   "tiempo":this.modoEditarLote.tiempo
               }
                axios({
                   method:"put",
                   url:"lotes/apoyo/"+data.idLote,
                   data:{
                       "precio":data.precio,
                       "area":data.area,
                       "norte":data.norte,
                       "sur":data.sur,
                       "este":data.este,
                       "oeste":data.oeste,
                       "tiempo":data.tiempo

                   }
               }).then(respuesta => {
                $("#modalEditarLote").trigger('click')
                this.$emit("actualizarLotes",id)
            })

           },
            cerrarModal:function(){
            $("#modalEditarLote").trigger('click')
            //$("#modalBloques").modal("hide")
            }
        
    }

    
}
</script>