<template>
    <nav>
        <ul class="pagination justify-content-center mb-0">
            <li v-bind:class="['page-item', {'disabled' : pagination.current_page == 1}]">
                <button class="page-link" v-on:click="paginate('previous')">Previous</button>
            </li>
            <li v-for="page_no in pagination.last_page" v-bind:key="page_no" v-bind:class="['page-item', {'active' : page_no == pagination.current_page}]">
                <button class="page-link" v-on:click="paginate(page_no)">{{ page_no }}</button>
            </li>
            <li v-bind:class="['page-item', {'disabled' : pagination.current_page == pagination.last_page}]">
                <button class="page-link" v-on:click="paginate('next')">Next</button>
            </li>
        </ul>
        <div class="font-italic text-muted text-center mb-2">
            <small>Showing from {{pagination.from}} to {{pagination.to}} out of <span class="font-weight-bold">{{pagination.total}} results</span></small>
        </div>
    </nav>
</template>

<script>
export default {
    props : ['pagination'],

    inject : ['fetchTodos'],

    methods : {
        paginate(page) {
            if (page == 'previous') {
                var url = 'todos?page=' + (this.pagination.current_page - 1);
            } else if (page == 'next') {
                var url = 'todos?page=' + (this.pagination.current_page + 1);
            } else {
                var url = 'todos?page=' + page;
            }
            this.fetchTodos(url);
            // Scroll animation to be added
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    }
}
</script>

<style>

</style>