<template>    
    <div class="panel panel-default">
        <div class="panel-heading">Tela de desclassificação de candidatos</div>
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
                            <th>Desclassificar?</th>
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
                                {{ record.nome_programa_pretendido }}
                            </td>
                            <td>
                               <a href="#" @click.prevent="desclassificar(record)">Sim</a>&nbsp;&nbsp;&nbsp;
                               <a href="#" @click.prevent="">Não</a><br>
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

                sort: {
                    key: 'id_candidato',
                    order: 'asc'
                },

                limit: 50,

                quickSearchQuery: '',

                desclassifica: {
                    id_candidato: null,
                    id_inscricao_pos: null,
                    programa_pretendido: null,
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

            desclassificar (record) {
                this.desclassifica.id_candidato = record.id_candidato
                this.desclassifica.id_inscricao_pos = record.id_inscricao_pos
                this.desclassifica.programa_pretendido = record.id_programa_pretendido
                axios.patch(`${this.endpoint}/${this.desclassifica.id_candidato}`, this.desclassifica).then(() =>{
                    this.getRecords().then(() => {
                        this.desclassifica.id_candidato = null
                        this.desclassifica.id_inscricao_pos = null
                        this.desclassifica.programa_pretendido = null
                    })
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