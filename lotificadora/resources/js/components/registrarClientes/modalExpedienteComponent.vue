<template>
        <div class="modal fade" id="modalExpediente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-address-book"></i> Expediente</h5>
                        <button type="button" class="close" v-on:click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="card elevation-2">
                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-user"></i> Cliente
                                                <small class="float-right">
                                                    <div class="btn-group">
                                                        <button class="btn btn-light btn-sm" v-on:click="modoEditar(verInfoCliente.id)"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                        <button class="btn btn-light btn-sm" v-on:click="eliminar(verInfoCliente.id)"><i class="fas fa-trash"></i></button>
                                                    </div>
                                                </small>
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            <address>
                                                <strong>Nombre Completo:</strong><br />
                                                &nbsp; {{verInfoCliente.nombreCompleto}}<br />
                                                <strong>Tel / Cel:</strong><br />
                                                &nbsp; {{verInfoCliente.cel}} / {{verInfoCliente.cel2}}<br />
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <address>
                                                <strong>Identidad:</strong><br />
                                                &nbsp; {{verInfoCliente.identidad}}<br />
                                                <strong>Dirección:</strong><br />
                                                &nbsp; {{verInfoCliente.direccion}}<br />
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <address>
                                                <strong>Correo Electrónico:</strong><br />
                                                &nbsp; {{verInfoCliente.correo}}<br />
                                            </address>
                                        </div>
                                    </div>
                                <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-male"></i> Referencia
                                                <!-- <small class="float-right">Registrado: 2/10/2014</small> -->
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            <address>
                                                <strong>Nombre Completo:</strong><br />
                                                &nbsp; {{verInfoCliente.r_nombre_completo}}<br />
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <address>
                                                <strong>Tel / Cel:</strong><br />
                                                &nbsp; {{verInfoCliente.r_cel}}<br />
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <address>
                                                <strong>Dirección:</strong><br />
                                                &nbsp; {{verInfoCliente.r_direccion}}<br />
                                            </address>
                                        </div>
                                    </div>
                                <hr>
                                <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-users"></i> Beneficiarios
                                                <small class="float-right"><button type="button" class="btn btn-light btn-sm" v-on:click="beneficiarios(verInfoCliente.id)"><i class="fas fa-user-plus"></i></button></small>
                                            </h4>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive table-striped">
                                            <table class="table table-sm responsive" id="beneficiarios">
                                                <thead class="bg-dark">
                                                    <tr>
                                                        <td class="text-left">#</td>
                                                        <td class="text-center">Nombre</td>
                                                        <td class="text-center">Identidad</td>
                                                        <td class="text-center">Parentesco</td>
                                                        <td class="text-center">Celular</td>
                                                        <td class="text-center">Correo</td>
                                                        <td class="text-center">Dirección</td>
                                                        <td class="text-center">Accioón</td>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(beneficiarios,k) in verInfoCliente.beneficiarios" :key="k">
                                                        <td class="text-left">{{k+1}}. </td>
                                                        <td class="text-center">{{beneficiarios.nombre_completo}}</td>
                                                        <td class="text-center"> {{beneficiarios.identidad}}</td>
                                                        <td class="text-center"> {{beneficiarios.parentezco}}</td>
                                                        <td class="text-center"> {{beneficiarios.cel}} / {{beneficiarios.cel2}}</td>
                                                        <td class="text-center"> {{beneficiarios.correo}}</td>              
                                                        <td class="text-center"> {{beneficiarios.direccion}} </td>   
                                                        <td class="text-center"> 
                                                            <button class="btn btn-light btn-sm"><i class="fa fa-edit" aria-hidden="true" v-on:click="modoEditarBeneficiario(beneficiarios.id)"></i></button>
                                                            <button class="btn btn-light btn-sm"><i class="fas fa-trash" v-on:click="eliminarBeneficiario(beneficiarios.id)"></i></button>    
                                                        </td>    
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2><label>Datos personales del cliente</label></h2>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h3><label>Nombre Completo:</label></h3>
                                                    <h4><p class="card-text"> {{verInfoCliente.nombreCompleto}}
                                                    </p></h4>
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h3><label>Numero de Identidad:</label></h3>
                                                    <h4><p class="card-text"> {{verInfoCliente.identidad}} </p></h4>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h3><label>Correo Electronico:</label></h3>
                                                    <template v-if="verInfoCliente.correo == null">
                                                        <h4><p class="card-text"> - </p></h4>
                                                    </template>
                                                    <template v-else>
                                                        <h4><p class="card-text"> {{verInfoCliente.correo}} </p></h4>
                                                    </template>
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h3><label>Tel/Cel:</label></h3>
                                                    <template v-if="verInfoCliente.cel2 == null">
                                                        <h4><p class="card-text"> {{verInfoCliente.cel}}</p></h4>
                                                    </template>
                                                    <template v-else>
                                                        <h4><p class="card-text"> {{verInfoCliente.cel}} / {{verInfoCliente.cel2}} </p></h4>
                                                    </template>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h3><label>Direccion:</label></h3>
                                                <h4><p class="card-text"> {{verInfoCliente.direccion}}</p></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <hr>
                        
                            <div class="card elevation-2">                
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2><label>Datos personales de la referencia</label></h2>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h3><label>Nombre Completo:</label></h3>
                                                    <h4><p class="card-text"> {{verInfoCliente.r_nombre_completo}}</p></h4>
                                                </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <h3><label>Tel/Cel:</label></h3>
                                                    <h4><p class="card-text"> {{verInfoCliente.r_cel}}</p></h4>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h3><label>Direccion:</label></h3>
                                                <h4><p class="card-text"> {{verInfoCliente.r_direccion}}</p></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card elevation-2">                
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2><label>Datos personales de los beneficiarios</label></h2>
                                        </div>
                                    </div>
                                    <hr>
                                    <div v-for="(beneficiarios,k) in verInfoCliente.beneficiarios" :key="k">
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <h3><label>Beneficiario # {{k+1}}:</label></h3>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h3><label>Nombre Completo:</label></h3>
                                                        <h4><p class="card-text"> {{beneficiarios.nombre_completo}}</p></h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h3><label>Identidad:</label></h3>
                                                        <h4><p class="card-text"> {{beneficiarios.identidad}}</p></h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <h3><label>Parentezco:</label></h3>
                                                        <h4><p class="card-text"> {{beneficiarios.parentezco}}</p></h4>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h3><label>Cel/Tel:</label></h3>
                                                        <template v-if="beneficiarios.cel2 == null">
                                                            <h4><p class="card-text"> {{beneficiarios.cel}}</p></h4>
                                                        </template>
                                                        <template v-else>
                                                            <h4><p class="card-text"> {{beneficiarios.cel}} / {{beneficiarios.cel2}}</p></h4>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h3><label>Correo:</label></h3>
                                                        <template v-if="beneficiarios.correo == null">
                                                            <h4><p class="card-text"> -</p></h4>
                                                        </template>
                                                        <template v-else>
                                                            <h4><p class="card-text"> {{beneficiarios.correo}}</p></h4>
                                                        </template>
                                                    </div>
                                                </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h3><label>Direccion:</label></h3>
                                                    <h4><p class="card-text"> {{beneficiarios.direccion}}</p></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="btn-group">
                                                    <button class="btn btn-light btn-sm"><i class="fa fa-edit" aria-hidden="true" v-on:click="modoEditarBeneficiario(beneficiarios.id)"></i></button>
                                                    <button class="btn btn-light btn-sm"><i class="fas fa-trash" v-on:click="eliminarBeneficiario(beneficiarios.id)"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>-->
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
                        <!-- <div class="btn-group">
                             <button class="btn btn-light btn-sm"><i class="fa fa-edit" aria-hidden="true" v-on:click="modoEditar(verInfoCliente.id)"></i></button>
                             <button class="btn btn-light btn-sm"><i class="fas fa-trash" v-on:click="eliminar(verInfoCliente.id)"></i></button>
                        </div> -->
                        <!-- <button type="button" class="btn btn-primary btn-sm" v-on:click="beneficiarios(verInfoCliente.id)">Agregar Beneficiarios</button> -->
                        <button type="button" class="btn btn-danger btn-sm" v-on:click="cerrarModal">Cerrar</button>
                    </div>
                </div>
            </div>
            <modal-registrar-beneficiarios-component :idCliente="idCliente" @actualizarExpediente="actualizarExpediente"></modal-registrar-beneficiarios-component>
            <modal-editar-cliente-component :editarCliente="editarCliente" @actualizarExpediente="actualizarExpediente"></modal-editar-cliente-component>
            <modal-editar-beneficiario-component :editarBeneficiario="editarBeneficiario" @actualizarExpediente="actualizarExpediente"></modal-editar-beneficiario-component>
        </div>

</template>

<script>
export default {
    props:["verInfoCliente"],
    data(){
        return{
            pNombre:"",
            sNombre:"",
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
            imagenMiniatura:'',
            idCliente:'',
            editarCliente:[],
            editarBeneficiario:[]

        }
    },
    mounted(){

    },
    methods:{
        verificar:function(){
               var data={
                   "identidad":this.identidad
               }
                axios.post('clientes', data).then(respuesta => {
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
            if((this.pNombre == "") || (this.pApellido == "") || (this.identidad == "") ||
                (this.cel == "") || (this.direccion == "") || (this.rNombre == "") ||
                (this.rCel == "") || (this.rDireccion == "") || (this.verificado == 1) || (this.escritura == 1)){
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
        agregarResidencial:function(){

            let formData = new FormData();
                    formData.append('pNombre',this.pNombre);
                    formData.append('sNombre',this.sNombre);
                    formData.append('pApellido',this.pApellido);
                    formData.append('sApellido',this.sApellido);
                    formData.append('identidad',this.identidad);
                    formData.append('correo',this.correo);
                    formData.append('cel',this.cel);
                    formData.append('cel2',this.cel2);
                    formData.append('direccion',this.direccion);
                    formData.append('rNombre',this.rNombre);
                    formData.append('rCel',this.rCel);
                    formData.append('rDireccion',this.rDireccion);
                    //formData.append('imagen',this.imagen);

            axios.post('clientes/apoyo', formData).then(respuesta => {
                this.pNombre = "",
                this.sNombre = "",
                this.pApellido = "",
                this.sApellido = "",
                this.identidad = "",
                this.correo = "",
                this.cel = "",
                this.cel2 = "",
                this.direccion = "",
                this.rNombre = "",
                this.rCel = "",
                this.rDireccion = "",
                this.verificado = 0,
                this.escritura = 0,
                this.boton = 0
                //this.$emit("agregarResidencial")
                $("#modalRegistrarCliente").trigger('click')
            })
 
             

            // $("#modalRegistrarResidencial").trigger('click')
           
        },
        eliminar:function(id){
            axios.delete("/clientes/"+id).then(respuesta => {
                console.log("Borrado")
            })
            $("#modalExpediente").trigger('click')
            this.$emit("actualizarClientes")
        },
        beneficiarios:function(id){
            this.idCliente = id
            $("#modalRegistrarBeneficiarios").modal("show")
        },
        actualizarExpediente:function(idCliente){
            axios.get("/clientes/"+idCliente).then(respuesta=>{
                this.verInfoCliente = respuesta.data[0]
            })
        },
        eliminarBeneficiario:function(id){
            axios.delete("/beneficiarios/"+id).then(respuesta => {
                this.verInfoCliente = respuesta.data[0]
            })
        },
        modoEditar:function(id){
                axios.get("/clientes/"+id+"/edit").then(respuesta=>{
                this.editarCliente = respuesta.data
                console.log(respuesta.data)
            })
           $("#modalEditarCliente").modal("show")
        },
        modoEditarBeneficiario:function(id){
                axios.get("/clientes/apoyo/"+id).then(respuesta=>{
                this.editarBeneficiario = respuesta.data
                console.log(respuesta.data)
            })
           $("#modalEditarBeneficiarios").modal("show")
        },
        cerrarModal:function(){
            $("#modalExpediente").trigger('click')
            this.$emit("actualizarClientes")
        }
    },
    computed:{
        img(){
            return this.imagenMiniatura;
        }
    }
    
}
</script>