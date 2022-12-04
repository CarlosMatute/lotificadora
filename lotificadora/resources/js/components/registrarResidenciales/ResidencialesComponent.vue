<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card elevation-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <i class="fa fa-home fa-4x" style=" width:600; height:600;"></i>   
                            </div>
                            <div class="col-md-8">
                                <h4 class=""><b>Residenciales</b></h4>
                                <p class="text-muted">En este modulo puede registrar y administrar todas las residenciales y sus lotes.</p>
                            </div>
                            <div class="col-md-3">
                                <div class="btn-group dropleft float-right align-self-stretch">                                        
                                    <button data-toggle="modal" data-target="#modalRegistrarResidencial" class="btn btn-sm btn-primary float-right align-self-stretch">Registrar Residencial</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col" v-for="(residencial,i) in residenciales" :key="i">
                <div class="card elevation-2">
                <img :src="'/dist/img/'+residencial.imagen" class="card-img-top" height="150">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-title"><b>Residencial:</b> {{residencial.nombre}}</h5>
                            <p class="card-text"><b>Bloques:</b> {{residencial.bloques.length}} &nbsp; <b>Lotes:</b> {{residencial.lotes.length}}</p>
                        </div>
                        <div class="col-md-3">
                            <button type="button" data-toggle="modal" v-on:click="bloques(residencial.idR)" class="btn btn-sm btn-primary float-right align-self-stretch">Entrar</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        
        <modal-registrar-residencial-component @agregarResidencial="agregarResidencial"></modal-registrar-residencial-component>
        <modal-bloques-component :verBloques="verBloques" @actualizarResidenciales="actualizarResidenciales"></modal-bloques-component>
    </div>
</template>

<script>
export default {
    data(){
        return{
            residenciales:[],
            verBloques:[]
        }
    },
    mounted(){
            axios.get('/residenciales').then(respuesta=>{
                this.residenciales = respuesta.data
            })

    },
    methods:{
        agregarResidencial:function(){
            // axios.get('/residenciales').then(respuesta=>{
            //     this.residenciales = respuesta.data
            // })

            location.reload();
         
           },
        bloques:function(idR){
            axios.get("residenciales/"+idR).then(respuesta=>{
                this.verBloques=respuesta.data
                console.log('ver residenciales')
                console.log(respuesta.data)
                $("#modalBloques").modal("show")
                })
        },
        actualizarResidenciales:function(){
            //axios.get('/residenciales').then(respuesta=>{
                //this.residenciales = respuesta.data
                location.reload();
            //})
        }
    }
    
}
</script>