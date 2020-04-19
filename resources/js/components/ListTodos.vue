<template>
    <div>
        <h2 class="text-center">List Todo</h2>
        <todo-item v-for="todo in todos" v-bind:key="todo.id" v-bind="todo"></todo-item>
        <pagination v-if="pagination.total > 1" v-bind:pagination="this.pagination"></pagination>
    </div>
</template>

<script>

// Import child components
import TodoItem from './TodoItem';
import Pagination from './Pagination';

export default {
    components : {
        'todo-item' : TodoItem,
        'pagination' : Pagination
    },
    
    data : function() {
        return {
            // Values of fetched results of todos_data are available as computed properties (todos & pagination)
            todos_data : {},
        }
    },

    computed : {
        todos : function() {
            return this.todos_data.data
            },
        
        pagination : function() {
            return {
                current_page : this.todos_data.current_page,
                first_page_url : this.todos_data.first_page_url,
                from : this.todos_data.from,
                last_page : this.todos_data.last_page,
                to : this.todos_data.to,
                total : this.todos_data.total
            }
        }
    },

    created : function() {
        this.fetchTodos('todos');
    },

    mounted : function() {
        this.$root.$on('refreshTodos', () => {
            this.fetchTodos('todos');
        })
    },

    methods : {
        fetchTodos : function(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                context: this
            })
            .done(function(json){
                this.todos_data = json;
            })
            .fail(function(){
                console.log('Request to fetch todos failed');
            })
        },
    },

    provide : function() {
        return {fetchTodos: this.fetchTodos};
    } 

}
</script>

<style>

</style>