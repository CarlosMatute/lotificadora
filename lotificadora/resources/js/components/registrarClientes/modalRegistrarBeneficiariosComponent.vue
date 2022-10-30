<template>
    <form @submit.prevent="agregarBeneficiario" enctype="multipart/form-data">
        <div class="modal fade" id="modalRegistrarBeneficiarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-user-plus"></i> Registrar Nuevo Beneficiario</h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" v-model="idCliente">
                    <div class="modal-body">
                            <div class="card elevation-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Datos personales del beneficiario</h4>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nombre Completo:</label>
                                                    <input type="text" v-model="nombre_completo" v-on:change="campos" class="form-control border-dark" placeholder="Escribe el nombre completo">
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Numero de Identidad </label> (sin guiones):
                                                    <template v-if="escritura == 0">
                                                        <template v-if="verificado == 0">
                                                            <input type="text" v-model="identidad" v-on:change="verificar" class="form-control border-dark" placeholder="Ejm: 1503199012345" maxlength="13">
                                                        </template>
                                                        <template v-else>
                                                            <input type="text" v-model="identidad" v-on:change="verificar" class="form-control border-dark" placeholder="Ejm: 1503199012345" maxlength="13">
                                                            <h6 style="color:#FF0000;">Este numero de identidad ya esta registrado.</h6>
                                                        </template>
                                                    </template>
                                                    <template v-else>
                                                        <input type="text" v-model="identidad" v-on:change="verificar" class="form-control border-danger" placeholder="Ejm: 1503199012345" maxlength="13">
                                                        <h6 style="color:#FF0000;">Identidad mal escrita.</h6>
                                                    </template>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tel/Cel </label> (sin guiones):
                                                    <input type="number" v-model="cel" min="0" max="999999999999999" v-on:change="campos" class="form-control border-dark" placeholder="Ejm: 98765432">
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tel/Cel 2</label> (opcional):
                                                    <input type="number" v-model="cel2" min="0" max="999999999999999" class="form-control border-dark" placeholder="Ejm: 98765432">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label>Parentezco: </label>
                                                    <input type="text" v-model="parentezco" v-on:change="campos" class="form-control border-dark" placeholder="Ejm: Hermano">
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Correo Electronico </label> (opcional):
                                                    <input type="email" v-model="correo" class="form-control border-dark" placeholder="Ejm: pedro@gmail.com">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Direccion:</label>
                                                <textarea class="form-control border-dark" v-model="direccion" v-on:change="campos" cols="30" rows="4" placeholder="Escribe la direccion" maxlength="255"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                        <!--<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Foto de la residencial</label>
                                           <input type="file" @change="obtenerImagen" class="form-control-file">
                                    </div>

                                    <figure>
                                        <img width="250" height="150" :src="img" alt="-No has seleccionado ninguna foto.">
                                    </figure>
                               </div>
                        </div>-->
                    </div>
                    
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                        <template v-if="boton == 1">
                            <button type="submit" class="btn btn-primary btn-sm">Registrar Beneficiario</button>
                        </template>
                        <template v-else>
                            <button type="submit" class="btn btn-primary btn-sm" disabled>Registrar Beneficiario</button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props:["idCliente"],
    data(){
        return{
            nombre_completo:"",
            parentezco:"",
            pApellido:"",
            sApellido:"",
            identidad:"",
            correo:"",
            cel:"",
            cel2:"",
            direccion:"",
            rNombre:"",
            rCel:"",
            rDireccion:"",
            verificado:0,
            escritura:0,
            boton:0,
            imagen:'',
            imagenMiniatura:''

        }
    },
    mounted(){

    },
    methods:{
        verificar:function(){
               var data={
                   "identidad":this.identidad,
                   "idCliente":this.idCliente
               }
                axios.post('beneficiarios/apoyo', data).then(respuesta => {
                    console.log(respuesta.data)
                this.verificado = respuesta.data
                this.campos()
            })
            this.escrituraIdentidad()
        },
        escrituraIdentidad:function(){
            var valoresAceptados  = /^([0-9])*$/;
            if(this.identidad.match(valoresAceptados )){
                this.escritura = 0
            }else{
                this.escritura = 1
            }
            
        },
        campos:function(){
            if((this.nombre_completo == "") || (this.identidad == "") || (this.parentezco == "") ||
                (this.cel == "") || (this.direccion == "") || 
                (this.verificado == 1) || (this.escritura == 1)){
                this.boton = 0
            }else{
                this.boton = 1
            }
        },
 
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
        agregarBeneficiario:function(){

            let formData = new FormData();
                    formData.append('nombreCompleto',this.nombre_completo);
                    formData.append('identidad',this.identidad);
                    formData.append('correo',this.correo);
                    formData.append('cel',this.cel);
                    formData.append('cel2',this.cel2);
                    formData.append('direccion',this.direccion);
                    formData.append('parentezco',this.parentezco);
                    formData.append('idCliente',this.idCliente)
                    //formData.append('imagen',this.imagen);

            axios.post('/beneficiarios', formData).then(respuesta => {
                console.log(respuesta.data)
                this.nombre_completo = "",
                this.identidad = "",
                this.correo = "",
                this.cel = "",
                this.cel2 = "",
                this.direccion = "",
                this.parentezco = "",
                this.verificado = 0,
                this.escritura = 0,
                this.boton = 0
                //this.$emit("agregarResidencial")
                $("#modalRegistrarBeneficiarios").trigger('click')
                this.$emit("actualizarExpediente",this.idCliente)
            })
 
             

            // $("#modalRegistrarResidencial").trigger('click')
           
        },
        cerrarModal:function(){
            $("#modalRegistrarBeneficiarios").trigger('click')
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