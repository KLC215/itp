<template>
    <el-progress
            :text-inside="true"
            :stroke-width="18"
            :percentage="progress"
            status="success">
    </el-progress>
</template>

<script>
    export default {
        props: ['count-all-sub-arcade-childs', 'attributes'],

        data() {
            return {
                count: this.countAllSubArcadeChilds,
                data: this.attributes,
                isCompletedCount: 0,
                progress: 0,
            };
        },

        methods: {
            calculateIsCompletedRatio() {
                const self = this;
                this.data.forEach((item) => {
                    if (item.completed) {
                        self.isCompletedCount += 1;
                    }
                });
            },
            convertProgress() {
                this.progress = _.ceil(this.isCompletedCount / this.count * 100, 0);
            }
        },

        created() {
            this.calculateIsCompletedRatio();
            this.convertProgress();
            console.log('count', this.count);
            console.log('isCompletedCount', this.isCompletedCount);
            console.log('data', this.data);
        }
    }
</script>

<style scoped>

</style>