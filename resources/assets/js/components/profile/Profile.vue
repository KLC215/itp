<template>
    <el-tabs v-model="activeTab" type="card">
        <el-tab-pane label="Statistics" name="statistics">
            <statistic :statistics="user.statistics"></statistic>
        </el-tab-pane>
        <el-tab-pane label="Badges" name="badges">
            <badge :user-badges="user.badges" :all-badges="all"></badge>
        </el-tab-pane>
        <el-tab-pane label="History" name="history" v-if="isMe">
            <history :histories="user.logs"></history>
        </el-tab-pane>
    </el-tabs>
</template>

<script>
    import Statistic from './Statistic.vue';
    import History from './History.vue';
    import Badge from './Badge.vue';

    export default {
        components: {
            Badge,
            Statistic,
            History
        },

        props: ['user-statistics', 'user-badges', 'user-history', 'user-is-me', 'all-badges'],

        data() {
            return {
                activeTab: 'statistics',
                user: {
                    statistics: this.userStatistics,
                    badges: this.userBadges,
                    logs: this.userHistory,
                },
                isMe: this.userIsMe,
                all: this.allBadges
            };
        },

        created() {
            console.log(this.user.statistics);
            console.log(this.user.badges);
            console.log(this.user.logs);
            console.log(this.isMe);
        }
    };
</script>

<style scoped>

</style>