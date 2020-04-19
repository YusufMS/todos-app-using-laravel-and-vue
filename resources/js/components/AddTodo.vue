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
                        <!-- <p>{{ title }}</p>
                        <p>{{ description }}</p> -->
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
                description : ''
            },
            form_visibility : false
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
            });
        }
    }
}
</script>

<style scoped>
    .button-slide-enter-active, .button-slide-leave-active {
    transition: opacity 1s;
    }
    .button-slide-enter, .button-slide-leave-to /* .fade-leave-active below version 2.1.8 */ {
    /* transform: translateY(100px); */
    opacity: 0;
    }
    .form-slide-enter-active, .form-slide-leave-active {
    transition: all 2s;
    }
    .form-slide-enter, .form-slide-leave-to /* .fade-leave-active below version 2.1.8 */ {
    transform: translateY(-200px);
    opacity: 0;
    }
</style>