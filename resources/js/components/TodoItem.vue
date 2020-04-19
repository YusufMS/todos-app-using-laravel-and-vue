<template>
    <div class="card mb-2">
        <div class="card-header bg-dark text-light py-2">
            <h5 class="m-0" v-html="title"></h5>
        </div>
        <div class="card-body py-2">
            <p class="card-text mb-1" v-html="description"></p>
            <div class="card-text text-right">
                <button class="btn btn-sm btn-primary">Edit</button>
                <remove-item v-bind:id="id"></remove-item>
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

        props : ['id', 'title', 'description']
    }
</script>
