
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('data-table-user', require('./components/DataTableUser.vue'));

// Vue.component('auxilia-selecao', require('./components/AuxiliaSelecao.vue'));

// const app = new Vue({
//     el: '#app'
// });

const AdminDocumentosMatricula =  require('./components/AdminDocumentosMatricula.vue');
const CoordenadorDocumentosMatricula =  require('./components/CoordenadorDocumentosMatricula.vue');
const DataTableUser =  require('./components/DataTableUser.vue');
const AuxiliaSelecao = require('./components/AuxiliaSelecao.vue');
const HomologaInscricoes = require('./components/HomologaInscricoes.vue');
const SelecionaCandidatos = require('./components/SelecionaCandidatos.vue');
const MudaRecomendante = require('./components/MudaRecomendante.vue');
const ContaCartasRecomendantes = require('./components/ContaCartasRecomendantes.vue');
const InscricoesNaoFinalizadas = require('./components/InscricoesNaoFinalizadas.vue');
const ListaRecomendacoesAtivas  = require('./components/ListaRecomendacoesAtivas.vue');

const app = new Vue({
    el: '#app',
    components: {
        AdminDocumentosMatricula,
        CoordenadorDocumentosMatricula,
        DataTableUser,
        AuxiliaSelecao,
        HomologaInscricoes,
        SelecionaCandidatos,
        MudaRecomendante,
        ContaCartasRecomendantes,
        InscricoesNaoFinalizadas,
        ListaRecomendacoesAtivas
    }
});