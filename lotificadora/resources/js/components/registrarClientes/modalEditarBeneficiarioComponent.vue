<template>

        <div class="modal fade" id="modalEditarBeneficiarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i> Editar Beneficiario</h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" v-model="editarBeneficiario.id_cliente">
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
                                                    <input type="text" v-model="editarBeneficiario.nombre_completo" v-on:change="campos" class="form-control border-dark" placeholder="Escribe el nombre completo">
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Numero de Identidad </label> (sin guiones):
                                                    <template v-if="escritura == 0">
                                                        <template v-if="verificado == 0">
                                                            <input type="text" v-model="editarBeneficiario.identidad" v-on:change="verificar" class="form-control border-dark" placeholder="Ejm: 1503199012345" maxlength="13">
                                                        </template>
                                                        <template v-else>
                                                            <input type="text" v-model="editarBeneficiario.identidad" v-on:change="verificar" class="form-control border-dark" placeholder="Ejm: 1503199012345" maxlength="13">
                                                            <h6 style="color:#FF0000;">Este numero de identidad ya esta registrado.</h6>
                                                        </template>
                                                    </template>
                                                    <template v-else>
                                                        <input type="text" v-model="editarBeneficiario.identidad" v-on:change="verificar" class="form-control border-danger" placeholder="Ejm: 1503199012345" maxlength="13">
                                                        <h6 style="color:#FF0000;">Identidad mal escrita.</h6>
                                                    </template>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tel/Cel </label> (sin guiones):
                                                    <input type="number" v-model="editarBeneficiario.cel" min="0" max="999999999999999" v-on:change="campos" class="form-control border-dark" placeholder="Ejm: 98765432">
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Tel/Cel 2</label> (opcional):
                                                    <input type="number" v-model="editarBeneficiario.cel2" min="0" max="999999999999999" class="form-control border-dark" placeholder="Ejm: 98765432">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label>Parentezco: </label>
                                                    <input type="text" v-model="editarBeneficiario.parentezco" v-on:change="campos" class="form-control border-dark" placeholder="Ejm: Hermano">
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Correo Electronico </label> (opcional):
                                                    <input type="email" v-model="editarBeneficiario.correo" class="form-control border-dark" placeholder="Ejm: pedro@gmail.com">
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Direccion:</label>
                                                <textarea class="form-control border-dark" v-model="editarBeneficiario.direccion" v-on:change="campos" cols="30" rows="4" placeholder="Escribe la direccion" maxlength="255"></textarea>

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
                            <button type="submit" class="btn btn-primary btn-sm" v-on:click="editar(editarBeneficiario.id)">Editar Beneficiario</button>
                        </template>
                        <template v-else>
                            <button type="submit" class="btn btn-primary btn-sm" disabled>Editar Beneficiario</button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
 
</template>

<script>
export default {
    props:["editarBeneficiario"],
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
                   "identidad":this.editarBeneficiario.identidad,
                   "idCliente":this.editarBeneficiario.id
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
            if(this.editarBeneficiario.identidad.match(valoresAceptados )){
                this.escritura = 0
            }else{
                this.escritura = 1
            }
            
        },
        campos:function(){
            if((this.editarBeneficiario.nombre_completo == "") || (this.editarBeneficiario.identidad == "") || (this.editarBeneficiario.parentezco == "") ||
                (this.editarBeneficiario.cel == "") || (this.editarBeneficiario.direccion == "") || 
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
        editar:function(id){
               var data={
                   "nombre_completo":this.editarBeneficiario.nombre_completo,
                   "identidad":this.editarBeneficiario.identidad,
                   "cel":this.editarBeneficiario.cel,
                   "cel2":this.editarBeneficiario.cel2,
                   "parentezco":this.editarBeneficiario.parentezco,
                   "correo":this.editarBeneficiario.correo,
                   "direccion":this.editarBeneficiario.direccion,
                   "idCliente":this.editarBeneficiario.id_cliente,
                   "idBeneficiario":id
               }
                axios({
                   method:"put",
                   url:"clientes/apoyo/"+data.idBeneficiario,
                   data:{
                       "nombre_completo":data.nombre_completo,
                       "identidad":data.identidad,
                       "cel":data.cel,
                       "cel2":data.cel2,
                       "parentezco":data.parentezco,
                       "correo":data.correo,
                       "direccion":data.direccion

                   }
               }).then(respuesta => {
                   console.log(respuesta.data)
               $("#modalEditarBeneficiarios").trigger('click')
                this.$emit("actualizarExpediente",data.idCliente)
            })

           },
        cerrarModal:function(){
            $("#modalEditarBeneficiarios").trigger('click')
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