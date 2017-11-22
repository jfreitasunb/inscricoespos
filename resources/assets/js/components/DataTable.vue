<template>
    <div class="panel panel-default">
        <div class="panel-heading">Teste</div>

        <div class="panel-body">
            <table class="table-responsive">
                <thead>
                    <tr>
                        <th v-for="coluna in response.displayable">
                            {{ coluna }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            dfsd
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        
        props: ['endpoint'],

        data () {

            return {

                response: []
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

