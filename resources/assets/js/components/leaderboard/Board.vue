<template>
    <div>
        <el-tabs v-model="activeName" type="border-card" @tab-click="changeTab">
            <el-tab-pane v-for="label in labels" :label="label.label" :name="label.activeName">
                <i class="el-icon-loading" v-show="!loaded"></i>
                <el-table
                        :data="tableData"
                        style="width: 100%"
                        v-show="loaded">
                    <el-table-column
                            prop="rank"
                            label="#"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="Player"
                            width="400">
                        <template scope="scope">
                            <a :href="showFormat.isAsset ? profileURL(scope.row.slug) : profileURL(scope.row.user.slug)">
                                <span><img :src="showFormat.isAsset ? scope.row.avatar : scope.row.user.avatar"
                                           class="img-responsive"
                                           :alt="showFormat.isAsset ? scope.row.name : scope.row.user.name" width="30"
                                           height="30"></span>
                                {{ showFormat.isAsset ? scope.row.name : scope.row.user.name }}
                            </a>
                        </template>
                    </el-table-column>
                    <el-table-column
                            v-if="currentTabName === 'exp'"
                            prop="exp"
                            label="EXP">
                    </el-table-column>
                    <el-table-column
                            v-if="currentTabName === 'coin'"
                            prop="coin"
                            label="Coin">
                    </el-table-column>
                    <el-table-column
                            v-if="currentTabName === 'avg_time'"
                            prop="average_time_taken"
                            label="Average Time Taken">
                    </el-table-column>
                    <el-table-column
                            v-if="currentTabName === 'time'"
                            prop="time_spent_coding"
                            label="Time Spent Coding">
                    </el-table-column>
                    <el-table-column
                            v-if="currentTabName === 'star'"
                            prop="star_received"
                            label="Star Received">
                    </el-table-column>
                </el-table>
            </el-tab-pane>
        </el-tabs>
    </div>

</template>

<script>
    import { PROFILE_URL } from '../../core/urls';

    export default {
        props: ['user-assets', 'user-statistics'],

        data() {
            return {
                activeName: 'exp',
                labels: [
                    { label: 'EXP', activeName: 'exp' },
                    { label: 'Coin', activeName: 'coin' },
                    { label: 'Average Time Taken', activeName: 'avg_time' },
                    { label: 'Time Spent Coding', activeName: 'time' },
                    { label: 'Star Received', activeName: 'star' },
                ],
                formatStandard: {
                    assets: this.userAssets,
                    statistics: this.userStatistics
                },
                showFormat: {
                    isAsset: true,
                    isStatistic: !this.isAsset,
                },
                tableData: [],
                loaded: false,
                currentTabName: 'exp'
            };
        },

        methods: {
            changeTab(tab) {
                this.$events.fire('changedTab', tab.name);
            },

            profileURL(slug) {
                return PROFILE_URL + slug;
            }
        },

        events: {
            loadedData(loaded) {
                const self = this;

                setTimeout(() => {
                    self.loaded = loaded
                }, 2000);
            },

            sentRemainData(users) {
                this.tableData = users;
            },

            changedCurrentTabName(tabName) {
                if (_.includes(this.formatStandard.assets, tabName)) {
                    this.showFormat.isAsset = true;
                } else if (_.includes(this.formatStandard.statistics, tabName)) {
                    this.showFormat.isAsset = false;
                }
                this.currentTabName = tabName;
            },

            clearOldRemainUsers() {
                this.tableData = [];
            }
        }
    }
</script>

<style scoped>

</style>