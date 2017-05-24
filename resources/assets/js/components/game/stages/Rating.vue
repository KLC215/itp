<template>
    <div>
        <el-rate v-model="stars" disabled></el-rate>
        <el-progress :percentage="progress" :status="status"></el-progress>
    </div>

</template>

<script>
    export default {
        props: ['stage'],

        data() {
            return {
                data: this.stage,
                stars: 0,
                progress: 0,
                status: ''
            };
        },

        methods: {
            convertStatistics() {
                if (this.data.completed) {
                    this.status = 'success';
                    this.progress = 100;
                    this.stars = JSON.parse(this.data.stats).stars;
                }
            }
        },

        created() {
            console.log('small', this.data);
            this.convertStatistics();
        }
    }
</script>

<style scoped>

</style>