<template>    
    <div class="panel panel-default">
        <div class="panel-heading">NAME OF TABLE</div>

        <div class="panel-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th v-for="column in response.displayable">
                                {{ column }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
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
                    displayable: [],
                    records: []
                }
            }
        },
        mounted () {
            this.getRecords()
        },

        methods: {

            getRecords () {
                return axios.get(`${this.endpoint}`).then((response) => {
                    this.response = response.data.data
                })
            }
        }
    }
</script>

