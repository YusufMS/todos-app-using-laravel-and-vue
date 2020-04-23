<template>
    <div>
        <div class="mb-3">
            <transition name="button-slide">
                <div v-show="!form_visibility" class="text-center">
                    <button class="btn btn-success" v-on:click.prevent="showForm()">Add New Todo</button>
                </div>
            </transition>
            <transition name="form-slide">
                <div v-show="form_visibility">
                    <h3 class="text-center">Add New Todo</h3>
                    <form class="form" method="POST" v-on:submit.prevent="addTodo">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" name="title" type="text" class="form-control" v-model="form_data.title">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" v-model="form_data.description"></textarea>
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
                            <button v-on:click.prevent="hideForm()" class="btn btn-danger">Exit</button>
                        </div>
                    </form>
                </div>
            </transition>
            <hr>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            form_data: {
                title : '',
                description : '',
                tags : []
            },
            form_visibility : false,
            search_text : '',
            search_result : [],
            // added_tags : []
        }
    },

    methods : {
        showForm: function () {
            // animation to be added
            this.form_visibility = true;
        },

        hideForm: function () {
            // animation to be added
            this.form_visibility = false;
        },

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
            })
            .fail(function (xhr) {
                this.$root.alerts = {type: 'error', content: JSON.parse(xhr.responseText).errors};
            })
            .always(function () {
                this.$root.$emit('refreshTodos');
                this.form_data.title = '';
                this.form_data.description = '';
                this.form_data.tags = [];
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
    /* .button-slide-enter-active, .button-slide-leave-active {
    transition: opacity 1s;
    }
    .button-slide-enter, .button-slide-leave-to {
    opacity: 0;
    }
    .form-slide-enter-active, .form-slide-leave-active {
    transition: all 2s;
    }
    .form-slide-enter, .form-slide-leave-to {
    transform: translateY(-200px);
    opacity: 0;
    } */
</style>