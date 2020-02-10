<template>    
    <div class="panel panel-default">
        <div class="panel-heading">Documentos dos Selecionados</div>
        <div class="panel-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="filter">Pesquisa rápida</label>
                    <input type="text" id="filter" class="form-control" v-model="quickSearchQuery">
                </div>
                <div class="form-group col-md-2">
                    <label id="seleciona_edital">Selecione o Edital</label>
                    <select id="seleciona_edital" class="form-control" v-model="seleciona_edital" @change="getRecords">
                        <option v-for="dado in response.editais" :value="dado.id_inscricao_pos">{{ dado.edital }}</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label id="limit">Limitar resultados à:</label>
                    <select id="limit" class="form-control" v-model="limit" @change="getRecords">
                        <option value="10">5</option>
                        <option value="20">10</option>
                        <option value="30">15</option>
                        <option value="">Todos</option>
                    </select>
                </div>
                <div class="col-md-offset-3 col-md-6">
                    <a :href="this.route" style="font-size:30px;"><span class="glyphicon glyphicon-download-alt"></span> Download dos documentos de todos os alunos</a>
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredRecords">
                            <td :class="{ 'carta_completa': record.arquivo_final === true, 'carta_incompleta': record.arquivo_final == false}">
                                {{ record.id_candidato }}
                            </td>
                            <td :class="{ 'carta_completa': record.arquivo_final === true, 'carta_incompleta': record.arquivo_final == false}">
                                {{ record.nome }}
                            </td>
                            <td :class="{ 'carta_completa': record.arquivo_final === true, 'carta_incompleta': record.arquivo_final == false}">
                                {{ record.edital }}
                            </td>
                            <td :class="{ 'carta_completa': record.arquivo_final === true, 'carta_incompleta': record.arquivo_final == false}">
                                {{ record.nome_programa_pretendido }}
                            </td>
                            <td :class="{ 'carta_completa': record.arquivo_final === true, 'carta_incompleta': record.arquivo_final == false}">
                                <div v-if="record.link_arquivo !== null">
                                    <a :href="''+record.link_arquivo" :download="''+record.nome_tratado" style="font-size:18px;"><span class="glyphicon glyphicon-download-alt"></span>{{ record.nome_tratado }}</a>
                                </div>
                                
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
                    records: []
                },

                sort: {
                    key: 'id_candidato',
                    order: 'asc'
                },

                limit: 30,

                seleciona_edital: null,

                quickSearchQuery: ''
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

                    limit: this.limit,
                    id: this.seleciona_edital
                })
            },

            sortBy (column) {
                
                this.sort.key  = column

                this.sort.order = this.sort.order  === 'asc' ? 'desc' : 'asc'
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