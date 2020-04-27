<template>
<div class="mb-1">
    <div class="px-2 border-bottom rounded-bottom">
        <!-- Todo Body -->
        <p class="m-0" v-if="completed == false" v-html="todo_item"></p>
        <p class="m-0" v-else-if="completed == true" v-html="`<del>` + todo_item + `</del>`"></p>

        <!-- Todo Footer (Buttons) -->
        <div class="d-flex align-items-center pb-1">
          <div v-if="tags.length > 0">
            <small class="text-muted font-italic">Tags :</small>
            <small v-for="tag in tags" v-bind:key="tag.id" class="badge badge-secondary ml-1">{{tag.tag_name}}</small>
          </div>
          <div v-else>
            <small class="text-muted font-italic">Not tagged</small>
          </div>
          <div id="buttons" class="ml-auto">
            <button v-if="completed == false" v-on:click.prevent="toggle_complete()" class="btn btn-sm btn-success">Mark Complete</button>
            <button v-else-if="completed == true" v-on:click.prevent="toggle_complete()" class="btn btn-sm btn-warning">Marked Complete</button>
            <button class="btn btn-sm btn-primary">Edit</button>
            <remove-item v-bind:id="id"></remove-item>
          </div>
        </div>
    </div>
</div>
</template>

<script>
    import RemoveItem from './RemoveItem'

    export default {
        components : {
            'remove-item' : RemoveItem
        },

        props : ['id', 'todo_item', 'tags', 'completed'],

        methods : {
          toggle_complete : function () {
            $.ajax({
              type: "PUT",
              url: "todos/" + this.id,
              data: {type: 'toggle_complete'},
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              // dataType: "dataType",
              context: this
            })
            .done(function(){
              this.$root.$emit('refreshTodos');
            })
            .fail(function(xhr) {
              console.log('Request to toggle complete failed');
            });
            // console.log('To be marked complete:' + this.id);
          }
        }
    }
</script>

<style scoped>
#buttons button{
  padding: 0px 8px !important;
  margin: 0px;
}
</style>
