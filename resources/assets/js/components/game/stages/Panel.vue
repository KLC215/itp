<template>
    <el-card class="box-card">
        <div class="col-xs-6 col-md-4">
            <el-card class="box-card">
                <table>
                    <tr>
                        <td><u>Stats</u></td>
                    </tr>
                    <tr>
                        <td><i class="el-icon-check" style="color: green;"></i></td>
                        <td>&nbsp;&nbsp;{{ stats.correct }}</td>
                    </tr>
                    <tr>
                        <td><i class="el-icon-close" style="color: red;"></i></td>
                        <td>&nbsp;&nbsp;{{ stats.wrong }}</td>
                    </tr>
                </table>
            </el-card>
        </div>
        <div class="col-xs-12 col-md-8">
            <el-card class="box-card">
                <u> {{ itemText }} </u>
                <div v-for="item in items">
                    {{ itemLength(item) }} x
                    <el-button :plain="true" type="primary"
                               @click="useItem(item)"
                               :disabled="disabled">
                        <img :src="item.image"
                             :alt="item.display_name"
                             width="50" height="50">
                    </el-button>
                </div>
            </el-card>
        </div>
    </el-card>
</template>

<script>
    export default {
        props: ['item-data'],

        data() {
            return {
                stats: {
                    correct: 0,
                    wrong: 0,
                },
                items: this.itemData,
                disabled: true,
            };
        },

        methods: {
            useItem(item) {
                switch (item.name) {
                    case 'give-me-10-seconds':
                        this.$events.fire('increaseTenSeconds', item);
                        break;
                    case 'give-me-a-heart':
                        this.$events.fire('increaseHealth', item);
                        break;
                }
            },
            itemLength(item) {
                return item.users.length ? item.users[0].pivot.quantity : '0';
            }
        },

        events: {
            updateCorrect() {
                this.stats.correct++;
            },
            updateWrong() {
                this.stats.wrong++;
                this.$events.fire('decreaseHealth');
            },
            availableItem() {
                if(!this.items[0].users.length || this.items[0].users[0].pivot.quantity === 0) {
                    return;
                }
                this.disabled = false;
            },
            disableItemButton() {
                this.disabled = true;
            }
        },

        computed: {
            itemText() {
                return this.items.length > 1 ? 'Items' : 'Item';
            },
        },

        created() {
            console.log(this.items);
        }
    }
</script>

<style scoped>

</style>