<template>
    <div>
        <!-- Button trigger modal -->
        <div class="text-center mb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTodoModal">Add New Item</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addTodoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-light" id="exampleModalLongTitle">Add New Todo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            <div class="modal-body">
                <form class="form" method="POST" v-on:submit.prevent="addTodo">
                    <div class="form-group">
                        <label for="todo_item">Todo Item</label>
                        <textarea name="todo_item" class="form-control" v-model="form_data.todo_item" placeholder="Add your todo item here."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <span v-for="(tag ,index) in form_data.tags" v-bind:key="index" class="badge bagde-pill badge-primary mx-1 my-auto">{{tag}}<a href="#" v-on:click.prevent="remove_tag(index)" class="badge badge-dark ml-1">X</a></span>
                        <input id="tags" name="tags" type="text" class="form-control" v-on:keyup="search_tag()" v-on:keydown.tab.prevent="add_tag()" v-model="search_text">
                        <div v-if="search_text != 0" class="text-muted small mt-2">
                            Suggestions :
                            <span v-if="search_result.length != 0">
                                <strong v-for="result in search_result" v-bind:key="result.id">{{result.tag_name}}, </strong>
                                (Press tab to add tag)
                            </span>
                            <span v-else>
                                <span>No tags matching. We'll record this as a new Tag. Press tab to add tag.</span>
                            </span>
                        </div>
                        <div v-else class="text-muted small mt-2">
                            Start typing to get suggestions
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <input type="submit" value="Add" class="btn btn-success">
                        <input type="reset" value="Reset" class="btn btn-dark">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Exit</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            form_data: {
                todo_item : '',
                tags : []
            },
            search_text : '',
            search_result : [],
        }
    },

    methods : {
        addTodo : function() {
            $.ajax({
                type: "POST",
                url: "todos",
                data: this.form_data,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                context: this
            })
            .done(function (res) {
                this.$root.alerts = {type: 'success', content: '<strong>Success</strong>!!! New todo has been added.'};
                this.form_data.todo_item = '';
                this.form_data.tags = [];
                this.$root.$emit('refreshTodos');
            })
            .fail(function (xhr) {
                this.$root.alerts = {type: 'error', content: JSON.parse(xhr.responseText).errors};
            })
            .always(function () {
                $('#addTodoModal').modal('hide');
            });
        },

        search_tag: function() {
            if(this.search_text != '') {
                $.ajax({
                    type : 'GET',
                    url : 'tags/search',
                    context : this,
                    data : 'search_string=' + this.search_text,
                })
                .done(function(res) {
                    this.search_result = res;
                })
                .fail(function() {
                    console.log('Tag search request Failed');
                })
            }
        },

        add_tag : function () {
            this.form_data.tags.push(this.search_text);
            this.search_text = '';
        },

        remove_tag : function (index) {
            this.form_data.tags.splice(index, 1);
        }
    }
}
</script>

<style scoped>

</style>
