<template>
    <div>
        <table class="table table-bordered">
            <tr>
                <th>Average Time Taken</th>
                <th>Time Spent Coding</th>
                <th>Star Received</th>
            </tr>
            <tr>
                <td>{{ stats.average_time_taken }}</td>
                <td>{{ stats.time_spent_coding }}</td>
                <td>{{ stats.star_received }}</td>
            </tr>
        </table>
        <statistics-chart :data="data" :width="600" :height="400"></statistics-chart>
    </div>

</template>

<script>
    import StatisticsChart from './statistics';
    import {
        transferToSeconds,
        transferSecondsToPercent,
        transferTimeToPercent,
        transferStarToPercent
    } from '../../utilities/helpers';

    export default {

        props: ['statistics'],

        components: {
            StatisticsChart
        },

        data() {
            return {
                stats: this.statistics,
                data: {
                    datasets: [
                        {
                            data: [],
                            backgroundColor: [
                                "#FF6384",
                                "#4BC0C0",
                                "#FFCE56",
                                "#E7E9ED",
                                "#36A2EB"
                            ],
                            label: 'Your statistics'
                        }
                    ],
                    labels: [
                        'Average Time Taken',
                        'Time Spent Coding',
                        'Star Received'
                    ]
                },
                statData: [],
            };
        },

        methods: {
            initData() {
                console.log(this.stats.average_time_taken);
                let avg = transferToSeconds(this.stats.average_time_taken);
                let overall = transferToSeconds(this.stats.time_spent_coding);
                /*console.log(overall);
                 console.log(transferSecondsToPercent(avg));
                 console.log(transferTimeToPercent(overall));
                 console.log(transferStarToPercent(this.stats.star_received));*/
                let data = [];
                data.push(transferSecondsToPercent(avg));
                data.push(transferTimeToPercent(overall));
                data.push(transferStarToPercent(this.stats.star_received));
                this.data.datasets[0].data = data;
                //console.log(this.data);
            }
        },

        created() {
            this.initData();
        }

    }
</script>

<style scoped>

</style>