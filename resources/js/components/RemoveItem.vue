<template>
    <button v-on:click.prevent="deleteItem()" class="btn btn-sm btn-danger">Remove</button>
</template>

<script>
export default {
    data () {
        return {
            url : 'todos/' + this.id 
        }
    },

    props : ['id'],

    inject : ['fetchTodos'],

    methods : {
        deleteItem : function () {
            $.ajax({
                type: "DELETE",
                url: this.url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                context:this
            })
            .done(function(res){
                // console.log(res);
            })
            .fail(function () {
                console.log('Deletion failed');
            })
            .always(function () {
                this.fetchTodos('todos');
            });
        }
    }
}
</script>

<style>

</style>