<template>
    <div>
        <div class="d-flex border-bottom bg-dark align-items-center justify-content-between text-light p-2 mb-2">
            <!-- Page Title -->
            <div class="d-flex">
                <h2 class="mx-1 my-0">Todo Items</h2>
                <div v-if="filter_tags.length > 0" class="my-auto mx-2">
                    <span class="font-weight-bold text-muted font-italic">Tags :</span>
                    <span class="badge badge-light mr-1" v-for="(tag, index) in filter_tags" v-bind:key="tag">
                        {{ tag }}
                        <button v-on:click="remove_tag(index)">x</button>
                    </span>
                </div>
            </div>
            <div class="d-flex">
                <!-- Filter by tags -->
                <div class="d-flex">
                    <span>Tags</span>
                    <input type="text" v-model="new_tag" v-on:keydown.tab.prevent="add_tag()" class="form-control form-control-sm mx-2" placeholder="Press tab to add tag">
                </div>
                <!-- Filter by status -->
                <div class="d-flex">
                    <span>Status</span>
                    <select v-model="filter_status" v-on:change="fetchTodos('todos')" type="" class="form-control form-control-sm mx-2">
                        <option value='all' selected>All</option>
                        <option value=0>Incomplete</option>
                        <option value=1>Completed</option>
                    </select>
                </div>
                <!-- Search Box -->
                <div class="d-flex">
                    <span>Search</span>
                    <input v-model="search_text" v-on:keyup="fetchTodos('todos')" type="text" class="form-control form-control-sm mx-2" placeholder="Enter to search todos">
                </div>
            </div>
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
            search_text : '',
            filter_status : 'all',
            new_tag : '',
            filter_tags : []
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
                context: this,
                data: {
                    search_string : this.search_text,
                    filter_status : this.filter_status,
                    filter_tags : this.filter_tags
                    }
            })
            .done(function(json){
                this.todos_data = json;
            })
            .fail(function(xhr, status, err){
                // this.$root.alerts = {type: 'error', content: JSON.parse(xhr.responseText).errors};
                console.log(xhr.responseJSON);
                console.log('Request to fetch todos failed');
            })
        },

        add_tag : function() {
            this.filter_tags.push(this.new_tag);
            this.new_tag = '';
            this.fetchTodos('todos');
        },
        remove_tag : function(index) {
            this.filter_tags.splice(index,1);
            this.fetchTodos('todos');
        }
    },

    provide : function() {
        return {fetchTodos: this.fetchTodos};
    }

}
</script>

<style>
.badge button {
    background-color: none;
    border: none;
    padding: 0px;
    margin: 0px;
}
</style>
