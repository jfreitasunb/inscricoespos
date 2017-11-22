<template>
    <div class="panel panel-default">
        <div class="panel-heading">Name of Table</div>

        <div class="panel-body">
            <table class="table-responsive">
                <thead>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            
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

        mounted () {
            
            console.log(this.endpoint)   
        }
    }
</script>

