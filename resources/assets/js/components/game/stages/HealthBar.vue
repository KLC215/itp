<template>
    <div>
        <el-card class="box-card">
            <div class="text-center">
                <i v-for="health in healths"
                   class="life fa fa-heart fa-4x"
                   aria-hidden="true"></i>
            </div>
        </el-card>
    </div>
</template>

<script>
    import { DEDUCT_ITEM_QTY_POST_URL } from "../../../core/urls";
    export default {
        props: ['functional-data'],

        data() {
            return {
                item: this.functionalData,
                healths: 3
            };
        },

        events: {
            decreaseHealth() {
                this.healths -= 1;
                if(this.healths === 0) {
                    this.$events.fire('noHealths');
                    this.$events.fire('disableItemButton');
                }
            },
            increaseHealth(item) {
                const self = this;

                this.healths += 1;
                item.users[0].pivot.quantity -= 1;
                if (item.users[0].pivot.quantity === 0) {
                    this.$events.fire('disableItemButton');
                }
                axios.post(DEDUCT_ITEM_QTY_POST_URL, {
                    itemId: item.id,
                    itemName: item.name
                }).then((response) => {
                    if (response.data.success) {
                        self.$message({
                            message: response.data.message,
                            type: 'success'
                        });
                    }
                });
            }
        },

        mounted() {
            this.$events.fire('showQuestionBlock');
            this.$events.fire('availableItem');
        },
    }
</script>

<style scoped>
    .life {
        color: red;
        margin-left: 10px;
        margin-right: 10px;
    }
</style>