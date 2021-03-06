<template>
    <div class="panel panel-default">
        <div class="panel-heading">Tela de Seleção dos Candidatos</div>
        <div class="panel-body">
            <div class="row">
                <div class="form-group col-md-10">
                    <label for="filter">Pesquisa rápida</label>
                    <input type="text" id="filter" class="form-control" v-model="quickSearchQuery">
                </div>
                <div class="form-group col-md-2">
                    <label id="limit">Limitar resultados à:</label>
                    <select id="limit" class="form-control" v-model="limit" @change="getRecords">
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="1000">1000</option>
                        <option value="">Todos</option>
                    </select>
                </div>
                <div class="col-md-offset-3 col-md-6" v-if="response.total_selecionados === response.total_homologados">
                    <a :href="this.route" style="font-size:30px;"><span class="glyphicon glyphicon-download-alt"></span> Download do PDF com os Candidatos Selecionados</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th v-for="column in response.visivel">
                                <span class="sortable" @click="sortBy(column)">{{ response.custom_columns[column] || column }}</span>

                                <div class="arrow" v-if="sort.key === column" :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc' }"></div>
                            </th>
                            <th>Contemplado com bolsa?</br> 1 - SIM</br> 0 - NÃO</th>
                            <th>Candidato Selecionado?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredRecords">
                            <td :class="{ 'carta_completa': record.selecionado === true, 'carta_incompleta': record.selecionado == false}">
                                {{ record.id }}
                            </td>
                            <td :class="{ 'carta_completa': record.selecionado === true, 'carta_incompleta': record.selecionado == false}">
                                {{ record.nome }}
                            </td>
                            <td :class="{ 'carta_completa': record.selecionado === true, 'carta_incompleta': record.selecionado == false}">
                                {{ record.nome_programa_pretendido }}
                            </td>
                            <td :class="{ 'carta_completa': record.selecionado === true, 'carta_incompleta': record.selecionado == false}">
                                <template>
                                    <div class="form-group" id="colocao" :class="{ 'has-error': seleciona.errors['colocao'] }">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" :name="record.id" v-model="seleciona.classificacao[record.id]">
                                        </div>
                                        <label for="inputType" class="col-sm-3 control-label">{{ record.colocacao }}</label>
                                        <span class="help-block" v-if="seleciona.errors['colocacao'] && seleciona.id_candidato === record.id_candidato">
                                            <strong>{{ seleciona.errors['colocacao'][0] }}</strong>
                                        </span>
                                    </div>
                                </template>
                            </td>
                            <td :class="{ 'carta_completa': record.selecionado === true, 'carta_incompleta': record.selecionado == false}">
                                <template>
                                    <div class="form-group" id="tera_bolsa" :class="{ 'has-error': seleciona.errors['contemplado_bolsa'] }">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" :name="record.id" v-model="seleciona.contemplado[record.id]">
                                        </div>
                                        <label for="inputType" class="col-sm-3 control-label">{{ record.contemplado_bolsa }}</label>
                                        <span class="help-block" v-if="seleciona.errors['contemplado_bolsa'] && seleciona.id_candidato === record.id_candidato">
                                            <strong>{{ seleciona.errors['contemplado_bolsa'][0] }}</strong>
                                        </span>
                                    </div>
                                </template>
                            </td>
                            <td>
                               <a href="#" @click.prevent="selecionarcandidato(record, 1)">Sim</a>&nbsp;&nbsp;&nbsp;
                               <a href="#" @click.prevent="selecionarcandidato(record, 0)">Não</a><br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

    import queryString from 'query-string'

    export default {
        props: ['endpoint', 'route'],
        data () {
            return {
                response: {
                    table: '',
                    displayable: [],
                    visivel: [],
                    total_inscritos: null,
                    total_homologados: 0,
                    records: []
                },

                sort: {
                    key: 'id_candidato',
                    order: 'asc'
                },

                limit: '',

                quickSearchQuery: '',

                seleciona: {
                    id_candidato: null,
                    id_inscricao_pos: null,
                    programa_pretendido: null,
                    status: null,
                    classificacao: [],
                    contemplado: [],
                    errors: []
                }

            }
        },

        computed: {
            filteredRecords () {
                
                let data = this.response.records

                data = data.filter((row) => {

                    return Object.keys(row).some((key) => {

                        return String(row[key]).toLowerCase().indexOf(this.quickSearchQuery.toLowerCase()) > -1
                    })
                })

                if (this.sort.key) {

                    data = _.orderBy(data, (i) => {

                        let value = i[this.sort.key]

                        if (!isNaN(parseFloat(value))) {

                            return parseFloat(value)
                        }

                        return String(i[this.sort.key]).toLowerCase()
                    }, this.sort.order)
                }

                return data
            }
        },

        methods: {

            getRecords () {
                return axios.get(`${this.endpoint}?${this.getQueryParameters()}`).then((response) => {
                    this.response = response.data.data
                })
            },

            getQueryParameters () {

                return queryString.stringify({

                    limit: this.limit
                })
            },

            sortBy (column) {
                
                this.sort.key  = column

                this.sort.order = this.sort.order  === 'asc' ? 'desc' : 'asc'
            },

            selecionarcandidato (record, status) {
                this.seleciona.id_candidato = record.id_candidato
                this.seleciona.id_inscricao_pos = record.id_inscricao_pos
                this.seleciona.programa_pretendido = record.id_programa_pretendido
                this.seleciona.status = status
                this.seleciona.colocacao = this.seleciona.classificacao[record.id]
                this.seleciona.classificacao = []
                if (typeof this.seleciona.contemplado[record.id] == 'undefined') {
                    this.seleciona.contemplado_com_bolsa = 0
                }else{
                    this.seleciona.contemplado_com_bolsa = this.seleciona.contemplado[record.id]    
                }
                this.seleciona.contemplado = []
                axios.patch(`${this.endpoint}/${this.seleciona.id_candidato}`, this.seleciona).then(() =>{
                    this.getRecords().then(() => {
                        this.seleciona.id_candidato = null
                        this.seleciona.id_inscricao_pos = null
                        this.seleciona.programa_pretendido = null
                        this.seleciona.status = null
                        this.seleciona.classificacao = []
                        this.seleciona.colocacao = null
                        this.seleciona.contemplado_com_bolsa = null
                    })
                }).catch((error) => {

                    this.seleciona.errors = error.response.data.errors
                })
            },
        },

        mounted () {
            this.getRecords()
        },
    }
</script>

<style lang="scss">
    
    .sortable {
        cursor: pointer;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: .6;

        &--asc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid #222;
        }

        &--desc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid #222;
        }

    }
</style>