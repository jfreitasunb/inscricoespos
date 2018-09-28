<template>    
    <div class="panel panel-default">
        <div class="panel-heading">NAME OF TABLE</div>

        <div class="panel-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Coluna</th>
                        </tr>
                    </thead>
                </table>
            </div>
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

