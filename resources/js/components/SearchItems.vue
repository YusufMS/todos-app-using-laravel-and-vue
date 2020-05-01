<template>
    <div class="d-flex">
        <span>Search</span>
        <input v-model="search_text" v-on:keyup="fetchTodos('todos')" type="text" class="form-control form-control-sm mx-2" placeholder="Enter to search todos">
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>