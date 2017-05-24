<template>
    <el-card class="box-card">
        <el-steps :active="active" finish-status="success" :align-center="true" :center="true">
            <el-step v-for="title in titles" :title="title"></el-step>
        </el-steps>
    </el-card>
</template>

<script>
    export default {
        props: ['data'],

        data() {
            return {
                titles: this.data.titles,
                active: this.data.active,
            };
        },
        events: {
            nextStep() {
                this.active += 1;
            }
        },
        created() {
            console.log(this.data);
        }
    }
</script>

<style scoped>
    .box-card {
        background-color: #EFF2F7;
        margin-bottom: 30px;
    }
</style>