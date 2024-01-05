<template>
    
        <div class="modal fade" id="modalElegirLote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Agregar Lotes</h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    
                       
                        <div class="row">
                                <div class="col-md-4">
                                     <div class="form-group">
                                        <label>Residencial:</label>
                                        <input list="browserss" class="form-control border-dark" id="browser" v-model="buscarResidencial" v-on:change="cargarBloques" autocomplete="off">
                                        <datalist id="browserss">
                                            <option v-for="residencial in residenciales" v-bind:value="residencial.idR"> {{residencial.nombre}}</option>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Bloques:</label> {{bloques.length}}
                                        <div>
                                            <template v-if="bloques.length == 0">
                                                <select class="form-control border-dark" v-model="bloque" v-on:change="cargarLotes" disabled>
                                                    <option disabled selected>--Elige un bloque--</option>
                                                    <!-- <option v-for="bloque in bloques" v-bind:value="bloque.id"> {{bloque.nombre}} </option> -->
                                                </select>
                                            </template>
                                            <template v-else>
                                                <select class="form-control border-dark" v-model="bloque" v-on:change="cargarLotes">
                                                    <option disabled selected>--Elige un bloque--</option>
                                                    <option v-for="bloque in bloques" v-bind:value="bloque.id"> {{bloque.nombre}} </option>
                                                </select>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Lotes:</label> {{lotes.length}}
                                        <div>
                                            <template v-if="lotes.length == 0">
                                                <select class="form-control border-dark" v-model="lote" disabled>
                                                    <option disabled selected>--Elige un lote--</option>
                                                    <!-- <option v-for="lote in lotes" v-bind:value="lote.id"> L-{{lote.nombre}} </option> -->
                                                </select>
                                            </template>
                                            <template v-else>
                                                <select class="form-control border-dark" v-model="lote" v-on:change="loteFinanciado">
                                                    <option disabled selected>--Elige un lote--</option>
                                                    <option v-for="lote in lotes" v-bind:value="lote.id"> L-{{lote.nombre}} </option>
                                                </select>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <template v-if="informacionLote.length == 0">

                        </template>
                        <template v-else>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                            <button type="button" v-on:click="loteFinanciado" class="btn btn-info btn-block btn-lg">{{informacionLote.residencial}} &nbsp;  {{informacionLote.bloque}} &nbsp;  L-{{informacionLote.lote}}</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" v-model="informacionLote.idLote">
                        </template>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-striped">
                                        <table class="table table-sm responsive" id="lotes">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <td class="text-left">#</td>
                                                    <td class="text-center">Residencial</td>
                                                    <td class="text-center">Bloque</td>
                                                    <td class="text-center">Lote</td>
                                                    <td class="text-center">Precio</td>
                                                    <td class="text-center">Acciones</td>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(lotes,i) in lotesFinanciados" :key="i">
                                                    <td class="text-left">{{i+1}}. </td>
                                                    <td class="text-center"> {{lotes.nombreR}}</td>
                                                    <td class="text-center"> {{lotes.nombreB}} </td>
                                                    <td class="text-center"> L-{{lotes.nombreL}} </td>
                                                    <td class="text-center"> L.{{lotes.precio}} </td>
                                                    <td class="text-center"><button class="btn btn-danger btn-sm"><i class="fas fa-trash" v-on:click="eliminar(lotes.idL)"></i></button></td>
                                        
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        
                    </div>

                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal" >Cerrar</button>
                        <template v-if="lotesFinanciados.length == 0">
                            <button class="btn btn-primary btn-sm" disabled>Agregar</button>
                        </template>
                        <template v-else>
                            <button type="button" class="btn btn-primary btn-sm" v-on:click="infoLotes">Agregar</button>
                        </template>
                    </div>
                </div>
            </div>
      
        </div>
   
</template>

<script>
export default {
    props:["lotesFinanciados"],
    data(){
        return{
            nombre:"",
            nBloques:"",
            descripcion:"",
            imagen:'',
            imagenMiniatura:'',
            dias:1,
            clientes:[],
            residenciales:[],
            buscarResidencial:"",
            bloque:"",
            bloques:[],
            lote:"",
            lotes:[],
            informacionLote:[],
            lotesFinanciados:[]

        }
    },
    mounted(){
            axios.get('/residenciales').then(respuesta=>{
                this.residenciales = respuesta.data
            })

    },
    methods:{
        cerrarModal:function(){
            $("#modalElegirLote").trigger('click')
        },
        eliminar:function(id){
            axios.delete('/lote_financiado/'+id).then(respuesta=>{
                this.actualizarTabla()
                this.cargarLotes()
            })
        },
        actualizarTabla:function(){
            axios.get('/lote_financiado').then(respuesta=>{
                this.lotesFinanciados = respuesta.data
                
            })
        },
        loteFinanciado:function(){
            var data={
                "idLote":this.lote
            }
            axios.post("lote_financiado", data).then(respuesta =>{
                //this.bloques.length = 0,
                //this.lotes.length = 0,
                this.informacionLote.length = 0,
                //this.buscarResidencial = "",
                //this.bloque = "",
                this.lote = ""
                //$("#modalElegirLote").trigger('click')
                //this.$emit("actualizarTabla")
                this.actualizarTabla()
                this.cargarLotes()
                //console.log(respuesta.data)
            })
            
        },
        cargarBloques:function(){
            axios.get("/bloque/apoyo/"+this.buscarResidencial).then(respuesta =>{
                this.bloques = respuesta.data
                
            })

        },
        cargarLotes:function(){
            axios.get("/bloque/apoyo/"+this.bloque+"/edit").then(respuesta =>{
                this.lotes = respuesta.data
                //if(this.lotes.length == 0){
                //    this.informacionLote.length = 0
                //    this.lote = ""
                //}else{

               // }
            })
        },
        infoLotes:function(){
            this.$emit("infoLotes")
            $("#modalElegirLote").trigger('click')
            // axios.get("/lotes/apoyo/"+this.lote+"/edit").then(respuesta =>{
            //     this.informacionLote = respuesta.data[0]
                
            // })
            //this.loteFinanciado()
            //this.actualizarTabla()
        },
        cambiarTiempo:function(){
            var data = {
                "idLote":this.informacionLote.idLote,
                "tiempo":this.informacionLote.tiempo
            }
            axios.post("bloque/apoyo", data).then(respuesta =>{
                this.informacionLote = respuesta.data[0]
                
            })
        }
    },
    computed:{

    }
    
}
</script>