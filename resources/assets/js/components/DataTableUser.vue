<template>    
    <div class="panel panel-default">
        <div class="panel-heading">{{ response.table }}</div>
        <div class="panel-body">
            <form action="#" @submit.prevent="getRecords">
                <label for="search">Pesquisa</label>
                <div class="row row-fluid">
                    <div class="group col-md-3">
                        <select class="form-control" v-model="search.column">
                            <option :value="column" v-for="column in response.displayable">
                                {{ column }}
                            </option>
                        </select>
                    </div>
                    <div class="group col-md-3">
                        <select class="form-control" v-model="search.operator">
                            <option value="equals">=</option>
                            <option value="contains">Contém</option>
                            <option value="starts_with">Começa com</option>
                            <option value="ends_with">Termina com</option>
                            <option value="greater_than">Maio que</option>
                            <option value="less_than">Menor que</option>
                        </select>
                    </div>
                    <div class="group col-md-3">
                        <div class="input-group">
                            <input type="text" id="search" v-model="search.value" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">Pesquisar</button>
                            </span>
                        </div>
                    </div>
                </div>

            </form>

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
                            <th v-for="column in response.displayable">
                                <span class="sortable" @click="sortBy(column)">{{ response.custom_columns[column] || column }}</span>

                                <div class="arrow" v-if="sort.key === column" :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc' }"></div>
                            </th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredRecords">
                            <td v-for="columnValue, column in record">
                                <template v-if="editing.id_user === record.id_user && isUpdatable(column)">
                                    <div class="form-group" :class="{ 'has-error': editing.errors[column] }">
                                        <input type="text" class="form-control" :name="columnValue" v-model="editing.form[column]">
                                        <span class="help-block" v-if="editing.errors[column]">
                                            <strong>{{ editing.errors[column][0] }}</strong>
                                        </span>
                                    </div>
                                </template> 

                                <template v-else>
                                    {{ columnValue }}    
                                </template>
                            </td>
                            <td>
                                <a href="#" @click.prevent="edit(record)" v-if="editing.id_user !== record.id_user">Editar</a>

                                <template v-if=" editing.id_user === record.id_user">
                                    <a href="#" @click.prevent="update()">Salvar</a><br>
                                    <a href="#" @click.prevent="editing.id_user = null">Cancelar</a>  
                                </template>
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
                    records: []
                },

                sort: {
                    key: 'id_user',
                    order: 'asc'
                },

                limit: 50,

                quickSearchQuery: '',

                editing: {
                    id_user: null,
                    form: {},
                    errors: []
                },

                search: {
                    value: null,
                    operator: 'equals',
                    column: 'id_user'
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

                    limit: this.limit,
                    ...this.search
                })
            },

            sortBy (column) {
                
                this.sort.key  = column

                this.sort.order = this.sort.order  === 'asc' ? 'desc' : 'asc'
            },

            edit (record) {

                this.editing.errors = []
                this.editing.id_user = record.id_user
                this.editing.form = _.pick(record, this.response.updatable)
            },

            isUpdatable (column) {

                return this.response.updatable.includes(column)
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