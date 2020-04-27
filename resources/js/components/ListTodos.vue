<template>
    <div>
        <div class="d-flex border-bottom bg-dark align-items-center justify-content-between text-light p-2 mb-2">
            <h2 class="mx-1 my-0">Todo Items</h2>
            <form method="get" class="form-inline justify-content-end">
                <div class="form-group">
                    <label for="search_box">Search</label>
                    <input type="text" name="search" id="search_box" v-model="search_text" v-on:keyup="fetchTodos('todos')" class="form-control form-control-sm mx-2">
                    <!-- <button type="submit" class="btn btn-success btn-sm"><span class="material-icons">search</span></button> -->
                    <div id="output"></div>
                </div>
            </form>
        </div>
        <todo-item v-for="todo in todos" v-bind:key="todo.id" v-bind="todo"></todo-item>
        <pagination v-if="pagination.total > 5" v-bind:pagination="this.pagination"></pagination>
    </div>
</template>


<script>

// Import child components
import TodoItem from './TodoItem';
import Pagination from './Pagination';

export default {
    components : {
        'todo-item' : TodoItem,
        'pagination' : Pagination,
        'search_results' : ''
    },

    data : function() {
        return {
            // Values of fetched results of todos_data are available as computed properties (todos & pagination)
            todos_data : {},
            search_text : ''
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

    // updated : function() {
    //     this.fetchTodos();
    // },

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
                context: this,
                data: {search_string : this.search_text}
            })
            .done(function(json){
                this.todos_data = json;
            })
            .fail(function(xhr, status, err){
                // this.$root.alerts = {type: 'error', content: JSON.parse(xhr.responseText).errors};
                // console.log(xhr);
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
