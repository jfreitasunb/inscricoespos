<template>
    <div class="panel panel-default">
        <div class="panel-heading">Name of Table</div>

        <div class="panel-body">
            I'm an example component!
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

