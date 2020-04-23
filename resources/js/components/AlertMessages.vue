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
        <!-- <div>
            <div id="success" class="success-alert row" role="alert">
                ABCD
                Add close button to alerts
                <button class="close_button" v-on:click.prevent="close_alert('success')">X</button>
            </div>
        </div> -->
    </div>
</template>

<script>
export default {
    data() {
        return {

            };
    },

    props : ['type', 'content'],

    methods : {
        close_alert : function(type) {
            $('#' + type).hide();
        }
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

    /* .close_button {
        border-style: none;
        background-color: inherit;
        padding: 0px;
        margin-left: auto;
        margin-top: auto;
        margin-bottom: auto;
        color: white;
        font-weight: bold;
    } */
</style>