<template>
    <!--<form @submit.prevent="agregarResidencial" enctype="multipart/form-data">-->
        <div class="modal fade" id="modalAgragarLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> <b>Agregar Lote al Bloque:</b> {{bloqueInfo2.nombre}} </h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" v-model="bloqueInfo2.ultimoLote">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Siguiente lote:</label><br>
                                        <button class="btn btn-info btn-block">L-{{bloqueInfo2.ultimoLote}}</button>
                
                                    </div>
                               </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Precio</label> L.:
                                        <input type="number" v-model="precio" class="form-control border-dark" placeholder="Precio del lote">
                                    </div>
                               </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Norte</label> m:
                                    <input type="number" v-model="norte" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sur</label> m:
                                    <input type="number" v-model="sur" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Este</label> m:
                                    <input type="number" v-model="este" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Oeste</label> m:
                                    <input type="number" v-model="oeste" class="form-control border-dark" placeholder="Ejmp: 15" v-on:change="calcularArea">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Area</label> m²:
                                    <input type="number" v-model="area" class="form-control border-dark" placeholder="Area por lote">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Años de financiamiento:</label>
                                    <input type="number" v-model="tiempo" class="form-control border-dark" placeholder="¿Cuantos años?">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm" v-on:click="agregarLotes(bloqueInfo2.id)">Guardar Lote</button>
                    </div>
                </div>
            </div>
        </div>
    <!--</form>-->
</template>

<script>
export default {
    props:["bloqueInfo2"],
    data(){
        return{
            precio:"",
            area:"",
            norte:0,
            sur:0,
            este:0,
            oeste:0,
            tiempo:""
        }
    },
    mounted(){


    },
    methods:{
            calcularArea:function(){
                var norte = this.norte;
                var sur = this.sur;
                var este = this.este
                var oeste = this.oeste
                norte = parseFloat(norte);
                sur = parseFloat(sur);
                este = parseFloat(este);
                oeste = parseFloat(oeste);
                var suma = (norte + sur);
                var division = suma / 2;
                var suma2 = (este + oeste);
                var division2 = suma2 / 2;
                var area = division * division2;
                this.area = area;
            },
           agregarLotes:function(id){
               var data={
                   "lote":this.bloqueInfo2.ultimoLote,
                   "precio":this.precio,
                   "area":this.area,
                   "norte":this.norte,
                   "sur":this.sur,
                   "este":this.este,
                   "oeste":this.oeste,
                   "idBloque":id,
                   "tiempo":this.tiempo
               }
                axios.post('lotes/apoyo', data).then(respuesta => {
                $("#modalAgragarLote").trigger('click')
                this.$emit("actualizarLotes",id)
            })
            
            this.precio = "",
            this.area = "",
            this.norte = 0,
            this.sur = 0,
            this.este = 0,
            this.oeste = 0,
            this.tiempo = ""

           },
            cerrarModal:function(){
            $("#modalAgragarLote").trigger('click')
            //$("#modalBloques").modal("hide")
            }
           
        
    }

    
}
</script>