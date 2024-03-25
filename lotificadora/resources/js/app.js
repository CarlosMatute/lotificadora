/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//require('datatables');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Componentes del dashboard
Vue.component('dashboard-component', require('./components/dashboard/dashboardComponent.vue').default);
Vue.component('modal-cuotas-mes-component', require('./components/dashboard/modalCuotasMesComponent.vue').default);
//Componentes de modulo Residenciales
Vue.component('residenciales-component', require('./components/registrarResidenciales/ResidencialesComponent.vue').default);
Vue.component('modal-registrar-residencial-component', require('./components/registrarResidenciales/modalRegistrarResidencialComponent.vue').default);
Vue.component('modal-bloques-component', require('./components/registrarResidenciales/modalBloquesComponent.vue').default);
Vue.component('modal-lotes-component', require('./components/registrarResidenciales/modalLotesComponent.vue').default);
Vue.component('modal-agregar-lotes-component', require('./components/registrarResidenciales/modalAgregarLotesComponent.vue').default);
Vue.component('modal-agregar-lote-component', require('./components/registrarResidenciales/modalAgregarLoteComponent.vue').default);
Vue.component('modal-editar-lote-component', require('./components/registrarResidenciales/modalEditarLoteComponent.vue').default);
Vue.component('modal-alerta-eliminar-bloque-component', require('./components/registrarResidenciales/modalAlertaEliminarBloqueComponent.vue').default);
Vue.component('modal-agregar-bloque-component', require('./components/registrarResidenciales/modalAgregarBloqueComponent.vue').default);
Vue.component('modal-editar-residencial-component', require('./components/registrarResidenciales/modalEditarResidencialComponent.vue').default);
Vue.component('modal-cambiar-imagen-residencial-component', require('./components/registrarResidenciales/modalCambiarImagenResidencialComponent.vue').default);
Vue.component('modal-alerta-eliminar-residencial-component', require('./components/registrarResidenciales/modalAlertaEliminarResidencialComponent.vue').default);
Vue.component('modal-reservar-lote-component', require('./components/registrarResidenciales/modalReservarLoteComponent.vue').default);
Vue.component('modal-reservacion-lote-component', require('./components/registrarResidenciales/modalReservacionLoteComponent.vue').default);
Vue.component('resumen-venta-lote-vendido-component', require('./components/registrarResidenciales/resumenVentaLoteVendidoComponent.vue').default);
//Componentes de modulo Clientes
Vue.component('clientes-component', require('./components/registrarClientes/clientesComponent.vue').default);
Vue.component('modal-registrar-cliente-component', require('./components/registrarClientes/modalRegistrarClienteComponent.vue').default);
Vue.component('modal-expediente-cliente-component', require('./components/registrarClientes/modalExpedienteComponent.vue').default);
Vue.component('modal-registrar-beneficiarios-component', require('./components/registrarClientes/modalRegistrarBeneficiariosComponent.vue').default);
Vue.component('modal-editar-cliente-component', require('./components/registrarClientes/modalEditarClienteComponent.vue').default);
Vue.component('modal-editar-beneficiario-component', require('./components/registrarClientes/modalEditarBeneficiarioComponent.vue').default);
//Componentes del modulo VenderLotes
Vue.component('vender-lotes-component', require('./components/venderLotes/venderLotesComponent.vue').default);
Vue.component('modal-registrar-venta-component', require('./components/venderLotes/modalRegistrarVentaComponent.vue').default);
Vue.component('modal-lotes-vender-component', require('./components/venderLotes/modalLotesVenderComponent.vue').default);
Vue.component('modal-elegir-lote-component', require('./components/venderLotes/modalElegirLoteComponent.vue').default);
Vue.component('modal-estado-credito-component', require('./components/venderLotes/modalEstadoCreditoComponent.vue').default);
Vue.component('modal-resumen-venta-component', require('./components/venderLotes/modalResumenVentaComponent.vue').default);
Vue.component('modal-resumen-venta-contado-component', require('./components/venderLotes/modalResumenVentaContadoComponent.vue').default);
Vue.component('modal-editar-venta-component', require('./components/venderLotes/modalEditarVentaComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
