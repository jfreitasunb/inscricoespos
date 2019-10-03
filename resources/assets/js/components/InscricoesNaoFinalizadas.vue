<template>    
    <div class="panel panel-default">
        <div class="panel-heading">Total de cartas enviadas por cada recomendante</div>
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
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th v-for="column in response.visivel">
                                <span class="sortable" @click="sortBy(column)">{{ response.custom_columns[column] || column }}</span>

                                <div class="arrow" v-if="sort.key === column" :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc' }"></div>
                            </th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredRecords">
                            <td>
                                {{ record.id_candidato }}
                            </td>
                            <td>
                                {{ record.nome }}
                            </td>
                            <td>
                                {{ record.email }}
                            </td>
                            <td>
                                {{ record.programa_pretendido }}
                            </td>
                            <td>
                                {{ record.created_at }}
                            </td>
                            <td>
                                {{ record.updated_at }}
                            </td>
                            <td>
                                <button @click='toggle = !toggle'> click here </button>
                                <div v-show='toggle'>
                                    <a href="#" @click.prevent="myFunction(record.documentos)">Documentos pessoais</a><br>
                                    <a href="#" @click.prevent="myFunction(record.comprovante)">Comprovante de idioma</a><br>
                                    <a href="#" @click.prevent="myFunction(record.historico)">Histórico</a><br>
                                    <a href="#" @click.prevent="myFunction(record.projeto)">Projeto</a><br>
                                    <ul>
                                        <li>O recomendante 1 <span style="color: #2ecc71" v-if="record.recomendante1"> FOI </span> <span v-else style="color: #e74c3c"> NÃO </span>foi notificado</li>
                                        <li>O recomendante 2 <span style="color: #2ecc71" v-if="record.recomendante2"> FOI </span> <span v-else style="color: #e74c3c"> NÃO </span>foi notificado</li>
                                        <li>O recomendante 3 <span style="color: #009fe5" v-if="record.recomendante3"> FOI </span> <span v-else style="color: #e74c3c"> NÃO </span>foi notificado</li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                
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
        props: ['endpoint'],
        data () {
            return {
                response: {
                    table: '',
                    displayable: [],
                    visivel: [],
                    records: []
                },
                toggle: false,

                sort: {
                    key: 'id_user',
                    order: 'asc'
                },

                limit: 50,

                quickSearchQuery: '',

                detalhes: {
                    id_user: null,
                    form: {},
                    errors: []
                },

                finalizar: {
                    id_user: null,
                    form: {},
                    errors: []
                },
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
            myFunction: function (arquivo) {   
                window.open(arquivo, "_blank");    
            },

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

            detalhe (record) {

                this.detalhes.errors = []
                this.detalhes.id_user = record.id_user
                this.detalhes.form = _.pick(record, this.response.updatable)
            },

            update () {

                axios.patch(`${this.endpoint}/${this.editing.id_user}`, this.editing.form).then(() => {

                    this.getRecords().then(() => {

                        this.editing.id_user = null
                        this.editing.form = {}

                    })

                }).catch((error) => {

                    this.editing.errors = error.response.data.errors
                })
            }
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