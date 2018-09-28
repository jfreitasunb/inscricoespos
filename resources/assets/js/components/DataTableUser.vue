<template>    
    <div class="panel panel-default">
        <div class="panel-heading">{{ response.table }}</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th v-for="column in response.displayable">
                                {{ column }}
                            </th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredRecords">
                            <td v-for="columnValue, column in record">{{ columnValue }}</td>
                            <td>Editar</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],
        data () {
            return {
                response: {
                    table: '',
                    displayable: [],
                    records: []
                }
            }
        },

        computed: {
            filteredRecords () {
                return this.response.records;
            }
        },

        methods: {

            getRecords () {
                return axios.get(`${this.endpoint}`).then((response) => {
                    this.response = response.data.data
                })
            }
        },

        mounted () {
            this.getRecords()
        },
    }
</script>

