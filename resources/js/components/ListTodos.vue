<template>
    <div>
        <h2 class="text-center">List Todo</h2>
        <todo-item v-for="todo in todos" v-bind:key="todo.id" v-bind:todo="todo"></todo-item>
    </div>
</template>

<script>
import TodoItem from './TodoItem'

export default {
    data : function() {
        return {
            todos_data : {},
        }
    },

    components : {
        'todo-item' : TodoItem
    },

    computed : {
        todos : function() {
            return this.todos_data.data
            },
        
        pagination : function() {
            return {
                current_page : this.todos_data.current_page,
                first_page_url : this.todos_data.first_page_url,
                last_page : this.todos_data.last_page,
                last_page_url : this.todos_data.last_page_url,
                next_page_url : this.todos_data.next_page_url,
                path : this.todos_data.path,
                per_page : this.todos_data.per_page,
                prev_page_url : this.todos_data.prev_page_url,
                to : this.todos_data.to,
                total : this.todos_data.total
            }
        }
    },

    created : function() {
        this.fetchTodos();
    },

    methods : {
        fetchTodos() {
            $.ajax({
                url: 'todos',
                type: 'GET',
                dataType: 'json',
                context: this
            })
            .done(function(json){
                // console.log(json)
                this.todos_data = json;
            })
            .fail(function(){
                console.log('Request to fetch post failed');
            })
        }
    }

}
</script>

<style>

</style>