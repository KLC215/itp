<template>
    <el-carousel :interval="3000" type="card" height="200px">
        <el-carousel-item v-for="(user, index) in users" :key="showFormat.isAsset ? user.id : user.user.id">
            <el-card class="box-card">

                <el-tag v-if="index === 0" type="success">No.1</el-tag>
                <el-tag v-else-if="index === 1">No.2</el-tag>
                <el-tag v-else type="gray">No.3</el-tag>

                <div class="media">
                    <div class="media-left">
                        <img :src="showFormat.isAsset ? user.avatar : user.user.avatar" class="media-object"
                             style="width:60px">
                    </div>
                    <div class="media-body">
                        <a :href="showFormat.isAsset ? profileURL(user.slug) : profileURL(user.user.slug)">
                            <h4 class="media-heading">{{ showFormat.isAsset ? user.name : user.user.name }}</h4>
                            <p v-if="currentTabName === 'exp'">
                                EXP: <span :style="no1Styles(index)">{{ user.exp }}</span>
                            </p>
                            <p v-if="currentTabName === 'coin'">
                                Coin: <span :style="no1Styles(index)">{{ user.coin }}</span>
                            </p>
                            <p v-if="currentTabName === 'avg_time'">
                                Avg time: <span :style="no1Styles(index)">{{ user.average_time_taken }}</span>
                            </p>
                            <p v-if="currentTabName === 'time'">
                                Total time: <span :style="no1Styles(index)">{{ user.time_spent_coding }}</span>
                            </p>
                            <p v-if="currentTabName === 'star'">
                                Stars received: <span :style="no1Styles(index)">{{ user.star_received }}</span>
                            </p>
                        </a>
                    </div>
                </div>

            </el-card>
        </el-carousel-item>
    </el-carousel>
</template>

<script>
    import { PROFILE_URL } from '../../core/urls';

    export default {
        props: ['user-assets', 'user-statistics'],

        data() {
            return {
                users: [],
                formatStandard: {
                    assets: this.userAssets,
                    statistics: this.userStatistics,
                },
                showFormat: {
                    isAsset: true,
                    isStatistic: !this.isAsset,
                },
                currentTabName: 'exp'
            };
        },

        methods: {
            no1Styles(index) {
                return index === 0 ? 'color: yellow' : ''
            },

            profileURL(slug) {
                return PROFILE_URL + slug;
            }
        },

        events: {
            clearOldTop3Users() {
                this.users = [];
            },

            changedCurrentTabName(tabName) {
                if (_.includes(this.formatStandard.assets, tabName)) {
                    this.showFormat.isAsset = true;
                } else if (_.includes(this.formatStandard.statistics, tabName)) {
                    this.showFormat.isAsset = false;
                }
                this.currentTabName = tabName;
                console.log(this.users);
            },

            sentTop3Data(users) {
                this.users = users;
            }
        },

    }
</script>

<style scoped>

</style>