<template>
    <div class="mx-3">
        <div v-if="type == 'error'">
            <div v-for="(values, name) in content" class="error-alert row" role="alert">
                <div class=d-inline>
                    Error in <span class="text-capitalize font-weight-bold">{{ name }}</span> : <span></span>
                </div>
                <div class="col pl-1">
                    <div v-for="value in values">{{ value }}</div>
                </div>
            </div>
        </div>
        <div v-else-if="type == 'success'">
            <div v-html="content" class="success-alert row" role="alert"></div>
        </div>
        <div>
            <div class="success-alert row" role="alert">ABCD</div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {

            };
    },

    props : ['type', 'content'],

    mounted : function() {

    }
}
</script>

<style>
    .error-alert {
        background-color: rgb(177, 15, 15);
        margin-bottom: 5px;
        color: white;
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 12px;
        letter-spacing: 1px;
    }

    .success-alert {
        background-color: rgb(37, 153, 56);
        margin-bottom: 5px;
        color: white;
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 12px;
        letter-spacing: 1px;
    }
</style>