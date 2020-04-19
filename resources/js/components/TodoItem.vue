<template>
    <div class="card mb-2">
        <div class="card-header bg-dark text-light py-2">
            <h5 class="m-0" v-html="title"></h5>
        </div>
        <div class="card-body py-2">
            <p class="card-text mb-1" v-html="description"></p>
            <div class="card-text text-right">
                <button class="btn btn-sm btn-primary">Edit</button>
                <button class="btn btn-sm btn-danger">Remove</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['id', 'title', 'description']
    }
</script>
