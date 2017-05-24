<template>
    <div class="pre-scrollable">
        <div class="panel panel-default"
             v-for="log in logs">
            <div class="panel-body">
                <h4 class="list-group-item-heading">{{ log.log }}</h4>
                <p class="pull-right"><i>{{ humanize(log.created_at) }}</i></p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['histories'],

        data() {
            return {
                logs: this.histories,
            };
        },

        methods: {
            humanize(dateTime) {
                return moment(dateTime, 'YYYY-MM-DD h:mm:ss').fromNow();
            }
        },

    }
</script>

<style scoped>

</style>