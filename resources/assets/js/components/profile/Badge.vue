<template>
    <div>
        <div class="col-sm-4"
             v-for="badge in all">
            <el-tooltip class="item" effect="dark" :content="badge.description" placement="top-start">
                <img :src="badge.image"
                     :class="imgClass(badge)"
                     :alt="badge.description"
                     width="200"
                     height="200">
            </el-tooltip>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['user-badges', 'all-badges'],

        data() {
            return {
                badges: this.userBadges,
                all: this.allBadges,
                iHave: [],
            };
        },

        methods: {
            imgClass(badge) {
                return this.iHave.indexOf(badge.id) >= 0 ? 'img-thumbnail' : ['img-thumbnail', 'some-grey']
            },
            chooseBadges() {
                const self = this;
                _.forEach(this.badges, (item) => {
                    self.iHave.push(item.id);
                });
                console.log(this.iHave);
            }
        },

        created() {
            console.log(this.all);
            console.log(this.badges);
            this.chooseBadges();
        }
    }
</script>

<style scoped>
    .item {
        margin-top: 20px;
    }

    .some-grey {
        -webkit-filter: grayscale(500%); /* Safari 6.0 - 9.0 */
        filter: grayscale(500%);
    }
</style>